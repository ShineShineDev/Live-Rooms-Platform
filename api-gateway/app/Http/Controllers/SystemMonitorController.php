<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import the Log facade

class SystemMonitorController extends Controller
{
    use GatherSystemMetrics;

    public function index()
    {
        $osFamily = PHP_OS_FAMILY;
        return view('system-monitor', compact('osFamily'));
    }

    public function getMonitorData()
    {
        $memoryStats = $this->getMemoryUsage();
        $cpuStats = $this->getCpuUsage(); // This will now return percentage for Linux

        return response()->json([
            'memory' => $memoryStats,
            'cpu' => $cpuStats,
            'timestamp' => now()->toDateTimeString(),
            'os_family' => PHP_OS_FAMILY,
        ]);
    }
}