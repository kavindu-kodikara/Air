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

<body>
    <nav class="navbar">
        <div class="navbar-container" style="display: flex;flex-direction: row;width: 100%">
            <div style="width: 50%;">
                <a href="#" class="logo">
                    <i class="fas fa-wind"></i>
                    {{$name}}
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

                <!-- Add this sensor registration form -->

                <div style="display: flex; flex-direction: row;gap: 30px">

                    <div style="width: 100%; display: flex; flex-direction: row;gap: 30px">

                        <div style="width: 50%;display: flex; flex-direction: row;gap: 30px">

                            <div class="card" style="width: 50%;">
                                <div style="display: flex; flex-direction: row;gap: 20px;align-items: center">
                                    <img src="{{ asset('images/allsensors.png') }}" style="width: 50px">
                                    <span class="fw-bold text-black-50" style="font-size: 18px">Total Seneors</span>
                                </div>
                                <div style="width: 100%; height: 100%;display: flex; justify-content: center;align-items: center">
                                    <span class="fs-1 fw-bold">0{{$totSensors}}</span>
                                </div>
                            </div>

                            <div class="card" style="width: 50%;">
                                <div style="display: flex; flex-direction: row;gap: 20px;align-items: center">
                                    <img src="{{ asset('images/live.png') }}" style="width: 50px">
                                    <span class="fw-bold text-black-50" style="font-size: 18px">User's Seneors</span>
                                </div>
                                <div style="width: 100%; height: 100%;display: flex; justify-content: center;align-items: center">
                                    <span class="fs-1 fw-bold">0{{$sensors->count()}}</span>
                                </div>
                            </div>

                        </div>

                        <div class="card" style="width: 50%;display: flex; flex-direction: row;align-items: center">
                            <div style="width: 100%">
                                <span class="text-black-50 fw-bold" style="font-size: 18px;">Sensor Status</span>

                                <div style="display: flex;flex-direction: column;width: 100%;height: 100%;gap: 10px;margin-left: 20px;margin-top: 20px">
                                    <div style="display: flex; flex-direction: row;gap: 20px;">
                                        <div style="width: 70px;height: 30px;background-color:#00BFA6;border-radius: 15px;display: flex;justify-content: center;align-items: center">
                                            <div style="width: 50px;height: 15px;background-color:white;border-radius: 15px"></div>
                                        </div>
                                        <span>Active Sensors %</span>
                                    </div>
                                    <div style="display: flex; flex-direction: row;gap: 20px;">
                                        <div style="width: 70px;height: 30px;background-color:#B0BEC5;border-radius: 15px;display: flex;justify-content: center;align-items: center">
                                            <div style="width: 50px;height: 15px;background-color:white;border-radius: 15px"></div>
                                        </div>
                                        <span>Dective Sensors %</span>
                                    </div>
                                </div>

                            </div>
                            <div style="width: 50%;height: 90%;display: flex;justify-content: center;align-items: center">
                                <canvas id="myChart" width="100" height="100" ></canvas> 
                            </div>
                            
                        </div>
                        
                    </div>
                    
    
                    
                </div>

               

                

                <div style="height: 30px; width: 100%;"></div>
                <div class="card">
                    <div style="display: flex; flex-direction: row;gap: 10px;align-items: center">
                        <img src="{{ asset('images/sensor.png') }}" style="width: 60px">
                        <span style="font-weight: bold; font-size: 20px;color: #3A0CA3">Sensor management</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Location Name</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sensors as $sensor)
                            <tr>
                                <td>{{$sensor['id']}}</td>
                                <td onclick="window.location='/sensor-chart?id={{$sensor['id']}}'">{{$sensor['location']}}</td>
                                <td>{{$sensor['lat']}}</td>
                                <td>{{$sensor['long']}}</td>
                                <td>
                                    @if ($sensor['status']==1)
                                    <button class="action-btn btn-unblock" onclick="sensorStatus({{$sensor['id']}},0)" >
                                        <i class="fas fa-lock-open"></i>
                                        Active
                                    </button>
                                    @else
                                    
                                    <button class="action-btn"  onclick="sensorStatus({{$sensor['id']}},1)">
                                        <i class="fas fa-lock"></i>
                                        Deactive
                                    </button>
                                    @endif
                                    
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
            </div>

            
            

         

          
        </main>
    </div>

    
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="../js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    let activeCount = {{$activeCount}};
    let sensors = {!! json_encode($sensors) !!};

    let activePercentage = sensors.length > 0 ? (activeCount / sensors.length) * 100 : 0;
    let deactivePercentage = sensors.length > 0 ? ((sensors.length - activeCount) / sensors.length) * 100 : 0;

    activePercentage = activePercentage.toFixed(2);
    deactivePercentage = deactivePercentage.toFixed(2);

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Deactive'],
            datasets: [{
                label: 'Status',
                data: [activePercentage, deactivePercentage],
                backgroundColor: ['#00BFA6', '#B0BEC5'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false
                }
            }
        }
    });
</script>




</body>
</html>