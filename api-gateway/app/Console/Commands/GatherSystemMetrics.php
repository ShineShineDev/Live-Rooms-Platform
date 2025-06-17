<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\TGNoti;

class GatherSystemMetrics extends Command
{
    use \App\Http\Controllers\GatherSystemMetrics;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:gather-metrics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gathers CPU and RAM usage';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $memoryStats = $this->getMemoryUsage();
        $cpuStats = $this->getCpuUsage();
        $cpuUsage = $cpuStats['usage_percent'];
        $memoryUsage = $memoryStats['usage_percent'];
        if ($cpuUsage >= 50 || $memoryUsage >= 80) {
            $text = $this->getMessage($cpuUsage, $memoryStats, now());
            TGNoti::dispatch('System Metrics Alert', $text, true);
        }
    }
    private function getMessage($cup, $memoryStats, $datetime)
    {
        return [
            "System Metrics Alert" => "",
            'CPU Usage' => $cup . '%',
            'Total Memory' => $memoryStats['total'],
            "Usage_Percent" => $memoryStats['usage_percent'] . '%',
            'Usage_GB' => $memoryStats['used'],
            'Available_GB' => $memoryStats['available'],
            'Date Time' => $datetime
        ];
    }
}