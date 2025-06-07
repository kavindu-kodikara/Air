<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Air Quality Monitoring - Colombo</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #4895ef;
            --secondary: #4cc9f0;
            --success: #38b000;
            --warning: #ffaa00;
            --danger: #ef233c;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --white: #ffffff;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            color: var(--dark);
            line-height: 1.6;
        }
        
        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 1rem 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .auth-buttons {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 0.6rem 1.25rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background-color: var(--white);
            color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--white);
            border: 2px solid var(--white);
        }
        
        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .dashboard-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .dashboard-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }
        
        .dashboard-subtitle {
            color: var(--gray);
            font-size: 1.1rem;
        }
        
        /* Cards */
        .card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 1.8rem;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .card-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin: 0;
        }
        
        /* Legend */
        .legend {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
            margin-top: 1rem;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            padding: 0.8rem;
            border-radius: 8px;
            background: rgba(248, 249, 250, 0.7);
            transition: transform 0.2s ease;
        }
        
        .legend-item:hover {
            transform: translateX(5px);
        }
        
        .legend-color {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        /* Map */
        #map {
            height: 550px;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        select, input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background-color: var(--white);
        }
        
        select:focus, input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(72, 149, 239, 0.2);
        }
        
        /* Chart Container */
        #chart-container {
            display: none;
            margin-top: 2rem;
        }
        
        #historical-chart {
            width: 100%;
            height: 400px;
        }
        
        /* Status Bar */
        .status-bar {
            text-align: right;
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        /* Auth Modals */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: var(--white);
            border-radius: 12px;
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            animation: modalFadeIn 0.3s ease;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal-header {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .modal-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin: 0 0 0.5rem 0;
        }
        
        .modal-subtitle {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }
        
        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray);
        }
        
        .form-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        
        .form-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .auth-buttons {
                width: 100%;
                justify-content: center;
            }
            
            .legend {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 0 1rem;
            }
            
            .dashboard-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" class="logo">
                <i class="fas fa-wind"></i>
                AirQuality Colombo
            </a>
            
            <div class="auth-buttons">
                <button class="btn btn-outline" >
                    <a href="/admin-login"  style="text-decoration: none; color: inherit;">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </button>
                <button class="btn btn-primary" id="register-btn">
                    <a href="/admin-register"  style="text-decoration: none; color: inherit;">
                        <i class="fas fa-sign-in-alt"></i> Register
                    </a>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Real-time Air Quality Monitoring</h1>
            <?php
            ?>
            <p class="dashboard-subtitle">Colombo District - <span id="last-updated">Just now</span></p>
        </div>

        <!-- AQI Legend -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">AQI Legend</h2>
                <i class="fas fa-info-circle" style="color: var(--primary-light); font-size: 1.2rem;"></i>
            </div>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #00e400;"></div>
                    <div><strong>Good</strong> (0-50)</div>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #ffff00;"></div>
                    <div><strong>Moderate</strong> (51-100)</div>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #ff7e00;"></div>
                    <div><strong>Unhealthy for Sensitive Groups</strong> (101-150)</div>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #ff0000;"></div>
                    <div><strong>Unhealthy</strong> (151-200)</div>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #8f3f97;"></div>
                    <div><strong>Very Unhealthy</strong> (201-300)</div>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #7e0023;"></div>
                    <div><strong>Hazardous</strong> (301+)</div>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Air Quality Map</h2>
                <button class="btn btn-outline" style="padding: 0.5rem 1rem; background-color: rgba(255,255,255,0.1);">
                    <i class="fas fa-layer-group"></i> Layers
                </button>
            </div>
            <div id="map"></div>
        </div>

        <!-- Historical Data Chart -->
        <div class="card" id="chart-container">
            <div class="card-header">
                <h2 class="card-title">Historical AQI Trend</h2>
                <div class="status-bar">Last 24 Hours</div>
            </div>
            <canvas id="historical-chart"></canvas>
        </div>
    </div>


   

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const loginBtn = document.getElementById('login-btn');
            const registerBtn = document.getElementById('register-btn');
            const loginModal = document.getElementById('login-modal');
            const registerModal = document.getElementById('register-modal');
            const closeModals = document.querySelectorAll('.close-modal');
            const switchToRegister = document.getElementById('switch-to-register');
            const switchToLogin = document.getElementById('switch-to-login');
            
            // Open modals
            if (loginBtn) loginBtn.addEventListener('click', () => {
                if (loginModal) loginModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
            
            if (registerBtn) registerBtn.addEventListener('click', () => {
                if (registerModal) registerModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
            
            // Close modals
            closeModals.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (loginModal) loginModal.style.display = 'none';
                    if (registerModal) registerModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                });
            });
            
            // Switch between modals
            if (switchToRegister) switchToRegister.addEventListener('click', (e) => {
                e.preventDefault();
                if (loginModal) loginModal.style.display = 'none';
                if (registerModal) registerModal.style.display = 'flex';
            });
            
            if (switchToLogin) switchToLogin.addEventListener('click', (e) => {
                e.preventDefault();
                if (registerModal) registerModal.style.display = 'none';
                if (loginModal) loginModal.style.display = 'flex';
            });
            
            // Close when clicking outside modal
            window.addEventListener('click', (e) => {
                if (e.target === loginModal) {
                    loginModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
                if (e.target === registerModal) {
                    registerModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
            
            // Form submissions (connect to your backend)
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            
            if (loginForm) {
                loginForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    // Connect to your login backend
                    console.log('Login form submitted');
                    if (loginModal) loginModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                });
            }
            
            if (registerForm) {
                registerForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    // Connect to your registration backend
                    console.log('Register form submitted');
                    if (registerModal) registerModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                });
            }

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

            // Fetch sensors and display on map (your existing backend call)
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
                            radius: 10,
                            fillColor: '#00e400',
                            color: '#fff',
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map);

                        console.log('Fetching AQI data from:', `/api/aqi/${sensor.id}`);
                        fetch(`/api/aqi/${sensor.id}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`Failed to fetch AQI data for sensor ${sensor.id}`);
                                }
                                return response.json();
                            })
                            .then(aqiData => {
                                console.log('AQI Data Response:', aqiData);
                                const latestAqi = aqiData[0]?.aqi_value || 0;
                                marker.setStyle({ fillColor: getMarkerColor(latestAqi) });

                                const safeLocationName = sensor.location_name || 'Unknown Location';
                                const safeSensorId = sensor.id ? String(sensor.id).replace(/[^a-zA-Z0-9-]/g, '') : 'unknown';

                                try {
                                    marker.bindPopup(
                                        `<div style="min-width: 250px;">
                                            <h4 style="margin: 0 0 10px 0; color: var(--primary-dark);">${safeLocationName}</h4>
                                            <p style="margin: 0 0 15px 0; font-size: 1.1rem;">
                                                Current AQI: <strong>${latestAqi}</strong>
                                            </p>
                                            <canvas id="mini-chart-${safeSensorId}" width="250" height="120"></canvas>
                                        </div>`
                                    );

                                    marker.on('popupopen', () => {
                                        const canvasId = `mini-chart-${safeSensorId}`;
                                        const canvas = document.getElementById(canvasId);
                                        
                                        if (canvas) {
                                            const ctx = canvas.getContext('2d');
                                            try {
                                                const labels = aqiData.map(data => 
                                                    new Date(data.recorded_at).toLocaleTimeString());
                                                const dataPoints = aqiData.map(data => data.aqi_value);
                                            
                                                new Chart(ctx, {
                                                    type: 'line',
                                                    data: {
                                                        labels: labels,
                                                        datasets: [{
                                                            label: 'AQI',
                                                            data: dataPoints,
                                                            borderColor: '#4361ee',
                                                            backgroundColor: 'rgba(67, 97, 238, 0.1)',
                                                            borderWidth: 2,
                                                            fill: true,
                                                            tension: 0.4
                                                        }]
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        scales: {
                                                            x: { display: false },
                                                            y: { beginAtZero: true }
                                                        },
                                                        plugins: { 
                                                            legend: { display: false }
                                                        }
                                                    }
                                                });
                                            } catch (error) {
                                                console.error('Error initializing mini chart:', error);
                                                marker.setPopupContent(
                                                    `<div style="padding: 10px;">
                                                        <h4 style="margin: 0 0 10px 0;">${safeLocationName}</h4>
                                                        <p>Current AQI: ${latestAqi}</p>
                                                        <p style="color: var(--gray);">Chart unavailable</p>
                                                    </div>`
                                                );
                                            }
                                        }
                                    });
                                } catch (error) {
                                    console.error('Error creating marker popup:', error);
                                }

                                // Add to sensor dropdown
                                if (sensorSelect) {
                                    const option = document.createElement('option');
                                    option.value = sensor.id;
                                    option.textContent = safeLocationName;
                                    sensorSelect.appendChild(option);
                                }
                            })
                            .catch(error => {
                                console.error(`Error fetching AQI data for sensor ${sensor.id}:`, error);
                            });
                    });
                })
                .catch(error => {
                    console.error('Error fetching sensors:', error);
                    // Display user-friendly error message
                    const errorElement = document.createElement('div');
                    errorElement.className = 'alert alert-danger';
                    errorElement.innerHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        Failed to load sensor data. Please try again later.
                    `;
                    document.querySelector('.container').prepend(errorElement);
                });

            // Historical Data Chart
            const chartContainer = document.getElementById('chart-container');
            const historicalChartCanvas = document.getElementById('historical-chart');
            let historicalChart;

            if (document.getElementById('sensor-select')) {
                document.getElementById('sensor-select').addEventListener('change', (event) => {
                    const sensorId = event.target.value;
                    if (sensorId && chartContainer && historicalChartCanvas) {
                        chartContainer.style.display = 'block';
                        console.log('Fetching historical AQI data from:', `/api/aqi/${sensorId}`);
                        fetch(`/api/aqi/${sensorId}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`Failed to fetch AQI data for sensor ${sensorId}`);
                                }
                                return response.json();
                            })
                            .then(aqiData => {
                                const labels = aqiData.map(data => 
                                    new Date(data.recorded_at).toLocaleTimeString());
                                const values = aqiData.map(data => data.aqi_value);

                                if (historicalChart) {
                                    historicalChart.destroy();
                                }

                                historicalChart = new Chart(historicalChartCanvas, {
                                    type: 'line',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'AQI Trend (Last 24 Hours)',
                                            data: values,
                                            borderColor: '#4361ee',
                                            backgroundColor: 'rgba(67, 97, 238, 0.1)',
                                            borderWidth: 2,
                                            fill: true,
                                            tension: 0.4
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            x: { 
                                                title: { 
                                                    display: true, 
                                                    text: 'Time',
                                                    color: '#666'
                                                },
                                                grid: {
                                                    display: false
                                                }
                                            },
                                            y: { 
                                                title: { 
                                                    display: true, 
                                                    text: 'AQI Value',
                                                    color: '#666'
                                                }, 
                                                beginAtZero: true 
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                labels: {
                                                    font: {
                                                        family: 'Poppins',
                                                        size: 14
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching historical data:', error);
                                if (chartContainer) {
                                    chartContainer.innerHTML = `
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Failed to load historical data. Please try again later.
                                        </div>
                                    `;
                                }
                            });
                    } else if (chartContainer) {
                        chartContainer.style.display = 'none';
                    }
                });
            }

            // Update last updated time
            function updateLastUpdated() {
                const lastUpdatedElement = document.getElementById('last-updated');
                if (lastUpdatedElement) {
                    const now = new Date();
                    lastUpdatedElement.textContent = now.toLocaleTimeString();
                }
            }
            
            setInterval(updateLastUpdated, 60000);
            updateLastUpdated();
        });

        // Your existing random AQI data functionality
        var map = L.map('map').setView([6.9271, 79.8612], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const sensors = @json($sensors);

        // Transform the sensors array into the cities format
        const cities = sensors.map(sensor => ({
            name: sensor.location,
            lat: parseFloat(sensor.lat), 
            lon: parseFloat(sensor.long)   
        }));
        
        function getRandomAQI() {
            return Math.floor(Math.random() * (305 - 20 + 1)) + 20;
        }
        
        function getAQILevel(aqi) {
            if (aqi <= 50) return { level: "Good", color: "green" };
            if (aqi <= 100) return { level: "Moderate", color: "yellow" };
            if (aqi <= 150) return { level: "Unhealthy for Sensitive Groups", color: "orange" };
            if (aqi <= 200) return { level: "Unhealthy", color: "red" };
            return { level: "Very Unhealthy", color: "purple" };
        }
        
        function updateMap() {
            map.eachLayer((layer) => {
                if (layer instanceof L.Circle) {
                    map.removeLayer(layer);
                }
            });
            
            cities.forEach(city => {
                let aqi = getRandomAQI();
                let { level, color } = getAQILevel(aqi);
                
                let circle = L.circle([city.lat, city.lon], {
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.6,
                    radius: 500
                }).addTo(map);
                
                circle.bindPopup(`<b>${city.name}</b><br>AQI: <span style="color:${color}; font-weight:bold;">${aqi} (${level})</span>`);
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const formData = new FormData();
                formData.append('city', city.name);
                formData.append('latitude', city.lat);
                formData.append('longitude', city.lon);
                formData.append('aqi_level', aqi);

                console.log(formData);
                
                fetch("http://127.0.0.1:8000/save-aqi", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => console.log("Saved:", data))
                .catch(error => console.error("Error:", error));
            });
        }
        
        updateMap();
        setInterval(updateMap, 60000000);
    </script>
</body>
</html>