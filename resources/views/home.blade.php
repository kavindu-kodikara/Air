<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Real-time Air Quality Monitoring Dashboard - Colombo</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        #map {
            height: 500px;
            width: 100%;
            margin-bottom: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .legend {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }
        .legend div {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        .legend .color-box {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        #chart-container {
            display: none;
            margin-top: 20px;
        }
        #historical-chart {
            max-width: 600px;
            margin: 0 auto;
        }
        .sensor-list {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Real-time Air Quality Monitoring Dashboard - Colombo</h1>

        <!-- AQI Legend -->
        <div class="legend">
            <h3>AQI Legend</h3>
            <div><span class="color-box" style="background-color: #00e400;"></span> Good (0-50)</div>
            <div><span class="color-box" style="background-color: #ffff00;"></span> Moderate (51-100)</div>
            <div><span class="color-box" style="background-color: #ff7e00;"></span> Unhealthy for Sensitive Groups (101-150)</div>
            <div><span class="color-box" style="background-color: #ff0000;"></span> Unhealthy (151-200)</div>
            <div><span class="color-box" style="background-color: #8f3f97;"></span> Very Unhealthy (201-300)</div>
            <div><span class="color-box" style="background-color: #7e0023;"></span> Hazardous (301+)</div>
        </div>

        <!-- Map Container -->
        <div id="map"></div>

        <!-- Sensor Selection for Historical Data -->
        <div class="sensor-list">
            <label for="sensor-select">Select Sensor for Historical Data:</label>
            <select id="sensor-select">
                <option value="">-- Select a Sensor --</option>
            </select>
        </div>

        <!-- Historical Data Chart -->
        <div id="chart-container">
            <h3>Historical AQI Trend (Last 24 Hours)</h3>
            <canvas id="historical-chart"></canvas>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize the map centered on Colombo
            const map = L.map('map').setView([6.9271, 79.8612], 13);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Function to determine marker color based on AQI
            function getMarkerColor(aqi) {
                if (aqi <= 50) return '#00e400';
                if (aqi <= 100) return '#ffff00';
                if (aqi <= 150) return '#ff7e00';
                if (aqi <= 200) return '#ff0000';
                if (aqi <= 300) return '#8f3f97';
                return '#7e0023';
            }

            // Fetch sensors and display on map
            console.log('Fetching sensors from:', '/api/sensors');
            fetch('/api/sensors')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch sensors');
                    }
                    return response.json();
                })
                .then(sensors => {
                    console.log('Sensors Response:', sensors);
                    const sensorSelect = document.getElementById('sensor-select');
                    sensors.forEach(sensor => {
                        console.log('Sensor ID:', sensor.id);
                        const marker = L.circleMarker([sensor.latitude, sensor.longitude], {
                            radius: 8,
                            fillColor: '#00e400',
                            color: '#000',
                            weight: 1,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map);

                        console.log('Fetching AQI data from:', /api/aqi/${sensor.id});
                        fetch(/api/aqi/${sensor.id})
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(Failed to fetch AQI data for sensor ${sensor.id});
                                }
                                return response.json();
                            })
                            .then(aqiData => {
                                console.log('AQI Data Response:', aqiData);
                                const latestAqi = aqiData[0]?.aqi_value || 0;
                                marker.setStyle({ fillColor: getMarkerColor(latestAqi) });

                                // Temporarily hardcode to isolate the issue
                                const safeLocationName = sensor.location_name; // Remove regex for now
                                console.log('Location Name (unsanitized):', safeLocationName);

                                // Validate sensor.id
                                const safeSensorId = Number(sensor.id);
                                if (isNaN(safeSensorId)) {
                                    console.error('Invalid sensor ID:', sensor.id);
                                    return; // Skip this sensor
                                }

                                try {
                                    marker.bindPopup(`
                                        <b>${safeLocationName}</b><br>
                                        Current AQI: ${latestAqi}<br>
                                        <canvas id="mini-chart-${safeSensorId}" width="200" height="100"></canvas>
                                    `);
                                } catch (error) {
                                    console.error('Error in bindPopup:', error);
                                    marker.bindPopup(`
                                        <b>${safeLocationName}</b><br>
                                        Current AQI: ${latestAqi}<br>
                                        <p>Chart unavailable</p>
                                    `);
                                }

                                marker.on('popupopen', () => {
                                    const ctx = document.getElementById(mini-chart-${safeSensorId}).getContext('2d');
                                    try {
                                        const labels = aqiData.map(data => new Date(data.recorded_at).toLocaleTimeString().replace(/[:\/]/g, '-'));
                                        console.log('Mini Chart Labels:', labels);
                                        new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: labels,
                                                datasets: [{
                                                    label: 'AQI',
                                                    data: aqiData.map(data => data.aqi_value),
                                                    borderColor: '#007bff',
                                                    fill: false
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    x: { display: false },
                                                    y: { beginAtZero: true }
                                                },
                                                plugins: { legend: { display: false } }
                                            }
                                        });
                                    } catch (error) {
                                        console.error('Error initializing mini chart:', error);
                                        marker.setPopupContent(`
                                            <b>${safeLocationName}</b><br>
                                            Current AQI: ${latestAqi}<br>
                                            <p>Chart unavailable</p>
                                        `);
                                    }
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching AQI data:', error);
                            });

                        const option = document.createElement('option');
                        option.value = sensor.id;
                        option.textContent = sensor.location_name;
                        sensorSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching sensors:', error);
                    alert('Failed to load sensors. Please try again later.');
                });

            // Historical Data Chart
            const chartContainer = document.getElementById('chart-container');
            const historicalChartCanvas = document.getElementById('historical-chart');
            let historicalChart;

            document.getElementById('sensor-select').addEventListener('change', (event) => {
                const sensorId = event.target.value;
                if (sensorId) {
                    chartContainer.style.display = 'block';
                    console.log('Fetching historical AQI data from:', /api/aqi/${sensorId});
                    fetch(/api/aqi/${sensorId})
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to fetch AQI data');
                            }
                            return response.json();
                        })
                        .then(aqiData => {
                            const labels = aqiData.map(data => new Date(data.recorded_at).toLocaleTimeString().replace(/[:\/]/g, '-'));
                            console.log('Historical Chart Labels:', labels);
                            const values = aqiData.map(data => data.aqi_value);

                            if (historicalChart) historicalChart.destroy();

                            historicalChart = new Chart(historicalChartCanvas, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'AQI Trend (Last 24 Hours)',
                                        data: values,
                                        borderColor: '#007bff',
                                        fill: false
                                    }]
                                },
                                options: {
                                    scales: {
                                        x: { title: { display: true, text: 'Time' } },
                                        y: { title: { display: true, text: 'AQI Value' }, beginAtZero: true }
                                    }
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching historical data:', error);
                            alert('Failed to load historical data. Please try again later.');
                        });
                } else {
                    chartContainer.style.display = 'none';
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  var map = L.map('map').setView([6.9271, 79.8612], 10); // Colombo, Sri Lanka

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // Update the marker to Colombo
  L.marker([6.9271, 79.8612]).addTo(map)
      .bindPopup('Current AQI: 50 (Moderate)')
      .openPopup();
</script>
</body>
</html>