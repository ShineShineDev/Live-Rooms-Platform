<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPIOException;

class RabbitMQService
{
    protected $connection;
    protected $channel;
    protected $connected = false;

    public function __construct()
    {
        try {
            $this->connection = new AMQPStreamConnection(
                env('RABBITMQ_HOST', 'rabbitmq'),
                env('RABBITMQ_PORT', 5672),
                env('RABBITMQ_USER', 'guest'),
                env('RABBITMQ_PASSWORD', 'guest')
            );

            $this->channel = $this->connection->channel();
            $this->connected = true;

        } catch (AMQPIOException $e) {
            Log::error('RabbitMQ connection failed: ' . $e->getMessage());
        } catch (Exception $e) {
            Log::error('RabbitMQ unexpected error: ' . $e->getMessage());
        }
    }

    public function publish($exchange, $routingKey, $message)
    {
        if (!$this->connected) {
            Log::warning('Publish skipped: not connected to RabbitMQ');
            return;
        }

        try {
            $this->channel->exchange_declare($exchange, 'fanout', false, false, false);

            $msg = new AMQPMessage($message);
            $this->channel->basic_publish($msg, $exchange, $routingKey);
            Log::error("RabbitMQ publish success");
        } catch (Exception $e) {
            Log::error("RabbitMQ publish error: " . $e->getMessage());
        }
    }

    public function subscribe($exchange, $callback)
    {
        if (!$this->connected) {
            Log::warning('Subscribe skipped: not connected to RabbitMQ');
            return;
        }

        try {
            $this->channel->exchange_declare($exchange, 'fanout', false, false, false);
            list($queue_name,,) = $this->channel->queue_declare("", false, false, true, false);
            $this->channel->queue_bind($queue_name, $exchange);

            $this->channel->basic_consume($queue_name, '', false, true, false, false, $callback);

            while ($this->channel->is_consuming()) {
                $this->channel->wait();
            }
        } catch (Exception $e) {
            Log::error("RabbitMQ subscribe error: " . $e->getMessage());
        }
    }

    public function __destruct()
    {
        try {
            if ($this->connected) {
                $this->channel->close();
                $this->connection->close();
            }
        } catch (Exception $e) {
            Log::warning("RabbitMQ close error: " . $e->getMessage());
        }
    }
}
