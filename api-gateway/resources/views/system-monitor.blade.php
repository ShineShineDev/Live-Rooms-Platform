<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Resource Monitor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #1a202c;
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        h2 {
            color: #2d3748;
            font-size: 1.75rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #edf2f7;
            padding-bottom: 0.5rem;
        }
        p {
            color: #4a5568;
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 500;
            color: #2d3748;
        }
        .info-value {
            color: #4a5568;
        }
        .error-message {
            color: #e53e3e;
            font-weight: 600;
            margin-top: 1rem;
        }
        .last-updated {
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #718096;
        }
        .loading-spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #3498db;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            margin: 1rem auto;
            display: none; /* Hidden by default */
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>System Resource Monitor</h1>

        <div id="loading-spinner" class="loading-spinner"></div>

        <h2>Memory Usage</h2>
        <div id="memory-stats-container">
            <p class="text-gray-500">Loading memory data...</p>
        </div>

        <h2>CPU Usage</h2>
        <div id="cpu-stats-container">
            <p class="text-gray-500">Loading CPU data...</p>
        </div>

        <p class="text-sm text-gray-500 mt-4">
            Operating System: {{ $osFamily }}
        </p>
        <p class="last-updated" id="last-updated">Last Updated: Never</p>
    </div>

    <script>
        // Function to fetch and display monitor data
        function fetchMonitorData() {
            document.getElementById('loading-spinner').style.display = 'block'; // Show spinner

            fetch('/monitor/data') // Make AJAX call to the new route
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Hide spinner after data is fetched
                    document.getElementById('loading-spinner').style.display = 'none';

                    // Update Memory Stats
                    const memoryContainer = document.getElementById('memory-stats-container');
                    if (data.memory) {
                        let memoryHtml = `
                            <div class="info-item"><span class="info-label">Total RAM:</span> <span class="info-value">${data.memory.total}</span></div>
                            <div class="info-item"><span class="info-label">Free RAM:</span> <span class="info-value">${data.memory.free}</span></div>
                        `;
                        if (data.memory.available && data.memory.available !== '0 B') { // Only show if available is meaningful for Linux
                            memoryHtml += `<div class="info-item"><span class="info-label">Available RAM:</span> <span class="info-value">${data.memory.available}</span></div>`;
                        }
                        memoryHtml += `
                            <div class="info-item"><span class="info-label">Used RAM:</span> <span class="info-value">${data.memory.used}</span></div>
                            <div class="info-item"><span class="info-label">Usage Percentage:</span> <span class="info-value">${data.memory.usage_percent}</span></div>
                        `;
                        memoryContainer.innerHTML = memoryHtml;
                    } else {
                        memoryContainer.innerHTML = '<p class="error-message">Could not retrieve memory usage.</p>';
                    }

                    // Update CPU Stats
                    const cpuContainer = document.getElementById('cpu-stats-container');
                    if (data.cpu) {
                        let cpuHtml = '';
                        // Now both Linux and Windows will have 'usage_percent'
                        if (data.cpu.usage_percent) {
                             cpuHtml = `<div class="info-item"><span class="info-label">CPU Usage:</span> <span class="info-value">${data.cpu.usage_percent}</span></div>`;
                             if (data.os_family === 'Linux') {
                                // Add the warning for Linux users about performance
                                cpuHtml += `<p class="text-sm text-red-500 mt-2"><strong>Warning:</strong> CPU percentage for Linux involves a short delay on the server. Frequent updates might impact responsiveness.</p>`;
                             }
                        }
                        cpuContainer.innerHTML = cpuHtml;
                    } else {
                        cpuContainer.innerHTML = '<p class="error-message">Could not retrieve CPU usage.</p>';
                    }

                    // Update last updated timestamp
                    if (data.timestamp) {
                        document.getElementById('last-updated').textContent = `Last Updated: ${new Date(data.timestamp).toLocaleString()}`;
                    }

                })
                .catch(error => {
                    console.error('Error fetching monitor data:', error);
                    document.getElementById('loading-spinner').style.display = 'none'; // Hide spinner on error
                    document.getElementById('memory-stats-container').innerHTML = '<p class="error-message">Failed to load memory data. Check console for details.</p>';
                    document.getElementById('cpu-stats-container').innerHTML = '<p class="error-message">Failed to load CPU data. Check console for details.</p>';
                });
        }

        // Fetch data immediately when the page loads
        document.addEventListener('DOMContentLoaded', fetchMonitorData);

        // Refresh data every 5 seconds (5000 milliseconds)
        setInterval(fetchMonitorData, 5000);
    </script>
</body>
</html>