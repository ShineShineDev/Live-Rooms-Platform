<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiGatewayController extends Controller
{
    protected $backendClient;
    protected $serviceMap;

    public function __construct()
    {
        $this->backendClient = new Client([
            'timeout' => 30,
            'connect_timeout' => 5,
            'http_errors' => false,
        ]);
        $this->serviceMap = config('app.external_services');
    }

    public function proxyRequest(Request $request, string $serviceName, ?string $path = null)
    {
        if (!isset($this->serviceMap[$serviceName])) {
            return response()->json(['error' => 'Unknown service'], 404);
        }
        \Log::info('Incoming proxy request', [
            'method' => $request->method(),
            'service' => $serviceName,
            'path' => $path,
            'body' => $request->all()
        ]);

        $baseUrl = rtrim($this->serviceMap[$serviceName], '/');
        $path = ltrim($path ?? '', '/');
        $url = $baseUrl . '/' . $path;
        try {
            $response = $this->backendClient->request($request->method(), $url, [
                'headers' => $request->headers->all(),
                'query' => $request->query(),
                'body' => $request->getContent(),
            ]);

            return response($response->getBody()->getContents(), $response->getStatusCode())
                ->withHeaders($response->getHeaders());

        } catch (\Exception $e) {
            return response()->json(['error' => 'Service unavailable', 'message' => $e->getMessage()], 500);
        }
    }
}