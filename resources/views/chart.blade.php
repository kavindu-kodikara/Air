<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .navbar {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            padding: 1rem 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding-left: 10%;
            padding-right: 10%;
        }
        
        .logo {
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            gap: 10px;
            color: white;
        }
        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-block {
            background-color: var(--danger);
            color: var(--white);
        }

        .btn-unblock {
            background-color: #38b000;
            color: #ffffff;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .action-btn i {
            font-size: 0.8rem;
        }
    </style>
</head>

<body >
    <nav class="navbar">
        <div class="navbar-container" style="display: flex;flex-direction: row;width: 100%">
            <div style="width: 50%;">
                <a href="#" class="logo">
                    <i class="fas fa-wind"></i>
                    AirQuality
                </a>
            </div>
            <div style="width: 50%;display: flex;justify-content: flex-end">
                <a href="#" class="logo">
                    <i class="fa-solid fa-right-from-bracket" onclick="adminLogout();"></i>
                </a>
            </div>
            
            
        </div>
    </nav>
    <div class="dashboard" style="padding-left:8%; padding-right: 8%">

        <main class="main-content">
            <!-- Find this section in your code -->
            <div id="dashboard" class="content-section active">
                <!-- Add code -->
                <div class="card">
                    <div id="chartContainer">
                        <canvas id="airQualityChart"></canvas>
                      </div>
                </div>
               
            </div>
          
        </main>
    </div>

    
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="../js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    let aqiData = {!! json_encode($aqiData) !!};
    let name = {!! json_encode($location) !!};

    const ctx = document.getElementById('airQualityChart').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: aqiData.map(entry => entry.created_at),
        datasets: [{
          label: 'PM2.5 (µg/m³)',
          data: aqiData.map(entry => entry.aqi_level),
          fill: true,
          backgroundColor: 'rgba(26, 187, 103, 0.2)',
          borderColor: '#1ABB67',
          tension: 0.3,
          pointRadius: 4,
          pointHoverRadius: 6
        }]
      },
      options: {
        responsive: true,
        plugins: {
          tooltip: {
            mode: 'index',
            intersect: false
          },
          title: {
            display: true,
            text: 'AirQuality '+name,
            font: {
              size: 18
            }
          },
          legend: {
            display: true
          }
        },
        interaction: {
          mode: 'nearest',
          axis: 'x',
          intersect: false
        },
        scales: {
          x: {
            display: false // 👈 Hides x-axis labels and gridlines
          },
          y: {
            title: {
              display: true,
              text: 'PM2.5 (µg/m³)'
            },
            beginAtZero: true
          }
        }
      }
    });
  </script>





</body>
</html>