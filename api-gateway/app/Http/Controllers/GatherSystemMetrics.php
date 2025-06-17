<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
trait GatherSystemMetrics
{
    /**
     * Helper function to format bytes into human-readable units (e.g., KB, MB, GB)
     *
     * @param int $bytes The number of bytes to format.
     * @param int $precision The number of decimal places to round to.
     * @return string The formatted string.
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Retrieves memory usage statistics for the current operating system.
     * (No changes needed here from previous version)
     *
     * @return array|null An associative array containing 'total', 'free', 'used',
     * 'available' (Linux only), and 'usage_percent' memory stats,
     * or null if data could not be retrieved.
     */
     function getMemoryUsage()
    {
        if (PHP_OS_FAMILY === 'Linux') {
            $memoryInfo = @file_get_contents('/proc/meminfo');
            if ($memoryInfo === false) {
                Log::error("Error: Could not read /proc/meminfo.");
                return null;
            }

            $lines = explode("\n", $memoryInfo);
            $memTotal = 0;
            $memFree = 0;
            $memAvailable = 0;

            foreach ($lines as $line) {
                if (strpos($line, 'MemTotal:') === 0) {
                    $memTotal = (int) preg_replace('/[^0-9]/', '', $line) * 1024;
                } elseif (strpos($line, 'MemFree:') === 0) {
                    $memFree = (int) preg_replace('/[^0-9]/', '', $line) * 1024;
                } elseif (strpos($line, 'MemAvailable:') === 0) {
                    $memAvailable = (int) preg_replace('/[^0-9]/', '', $line) * 1024;
                }
            }

            if ($memTotal > 0) {
                $memUsed = $memTotal - ($memAvailable > 0 ? $memAvailable : $memFree);
                $memUsagePercent = round(($memUsed / $memTotal) * 100, 2);

                return [
                    'total' => $this->formatBytes($memTotal),
                    'free' => $this->formatBytes($memFree),
                    'available' => $this->formatBytes($memAvailable),
                    'used' => $this->formatBytes($memUsed),
                    'usage_percent' => $memUsagePercent . '%',
                ];
            }
        } elseif (PHP_OS_FAMILY === 'Windows') {
            $outputTotal = [];
            @exec("wmic ComputerSystem get TotalPhysicalMemory /Value", $outputTotal);
            $totalMemory = 0;
            foreach ($outputTotal as $line) {
                if (preg_match('/^TotalPhysicalMemory=(\d+)$/', trim($line), $matches)) {
                    $totalMemory = (int) $matches[1];
                    break;
                }
            }

            $outputFree = [];
            @exec("wmic OS get FreePhysicalMemory /Value", $outputFree);
            $freeMemory = 0;
            foreach ($outputFree as $line) {
                if (preg_match('/^FreePhysicalMemory=(\d+)$/', trim($line), $matches)) {
                    $freeMemory = (int) $matches[1] * 1024;
                    break;
                }
            }

            if ($totalMemory > 0) {
                $usedMemory = $totalMemory - $freeMemory;
                $usagePercent = round(($usedMemory / $totalMemory) * 100, 2);
                return [
                    'total' => $this->formatBytes($totalMemory),
                    'free' => $this->formatBytes($freeMemory),
                    'used' => $this->formatBytes($usedMemory),
                    'usage_percent' => $usagePercent . '%',
                ];
            } else {
                Log::error("Error: Could not retrieve total physical memory on Windows.");
            }
        }
        return null;
    }

    /**
     * Internal helper to read CPU statistics from /proc/stat
     * @return array|null
     */
    private function _getLinuxCpuStat()
    {
        $stat = @file_get_contents('/proc/stat');
        if ($stat === false) {
            Log::error("Error: Could not read /proc/stat.");
            return null;
        }
        $lines = explode("\n", $stat);
        foreach ($lines as $line) {
            if (strpos($line, 'cpu ') === 0) { // 'cpu ' (with space) for aggregate CPU
                $parts = preg_split('/\s+/', $line);
                // The fields are user, nice, system, idle, iowait, irq, softirq, steal, guest, guest_nice
                return [
                    'user' => (int) ($parts[1] ?? 0),
                    'nice' => (int) ($parts[2] ?? 0),
                    'system' => (int) ($parts[3] ?? 0),
                    'idle' => (int) ($parts[4] ?? 0),
                    'iowait' => (int) ($parts[5] ?? 0),
                    'irq' => (int) ($parts[6] ?? 0),
                    'softirq' => (int) ($parts[7] ?? 0),
                    'steal' => (int) ($parts[8] ?? 0),
                    'guest' => (int) ($parts[9] ?? 0), // Not always present, handle gracefully
                    'guest_nice' => (int) ($parts[10] ?? 0), // Not always present
                ];
            }
        }
        return null;
    }

    /**
     * Retrieves CPU usage statistics for the current operating system.
     *
     * @return array|null An associative array containing CPU percentage (Linux/Windows),
     * or null if data could not be retrieved.
     */
     function getCpuUsage()
    {
        if (PHP_OS_FAMILY === 'Linux') {
            $stat1 = $this->_getLinuxCpuStat();
            if (!$stat1) {
                Log::error("Could not get initial CPU stats for percentage calculation.");
                return null;
            }

            // WARNING: Introducing a sleep delays the response. For web servers,
            // this can reduce responsiveness. Consider external monitoring tools
            // for production-grade real-time percentage data.
            usleep(500000); // Sleep for 0.5 seconds (500,000 microseconds) - sufficient for a sample

            $stat2 = $this->_getLinuxCpuStat();
            if (!$stat2) {
                Log::error("Could not get second CPU stats for percentage calculation.");
                return null;
            }

            // Calculate total CPU time for both samples
            $totalCpuTime1 = $stat1['user'] + $stat1['nice'] + $stat1['system'] + $stat1['idle'] + $stat1['iowait'] + $stat1['irq'] + $stat1['softirq'] + $stat1['steal'] + $stat1['guest'] + $stat1['guest_nice'];
            $totalCpuTime2 = $stat2['user'] + $stat2['nice'] + $stat2['system'] + $stat2['idle'] + $stat2['iowait'] + $stat2['irq'] + $stat2['softirq'] + $stat2['steal'] + $stat2['guest'] + $stat2['guest_nice'];

            // Calculate idle time for both samples
            $idleTime1 = $stat1['idle'] + $stat1['iowait'];
            $idleTime2 = $stat2['idle'] + $stat2['iowait'];

            // Calculate differences
            $totalDiff = $totalCpuTime2 - $totalCpuTime1;
            $idleDiff = $idleTime2 - $idleTime1;

            if ($totalDiff == 0) {
                return ['usage_percent' => '0.00%']; // Avoid division by zero
            }

            $cpuUsagePercent = round((($totalDiff - $idleDiff) / $totalDiff) * 100, 2);
            return ['usage_percent' => $cpuUsagePercent];

        } elseif (PHP_OS_FAMILY === 'Windows') {
            $output = [];
            @exec("wmic cpu get loadpercentage /Value", $output);
            foreach ($output as $line) {
                if (preg_match('/^LoadPercentage=(\d+)$/', trim($line), $matches)) {
                    return ['usage_percent' => $matches[1]];
                }
            }
            Log::error("Error: Could not retrieve CPU load percentage on Windows.");
        }
        return null;
    }
}
