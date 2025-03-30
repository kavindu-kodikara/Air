<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="dashboard">
        <nav class="navbar">
            <div class="menu-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </div>
            <div class="profile">
                <i class="fas fa-user-circle fa-2x"></i>
            </div>
        </nav>

        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <ul class="sidebar-menu">
                <li class="active" data-section="dashboard"><i class="fas fa-home"></i>Dashboard</li>
                <li data-section="users"><i class="fas fa-users"></i>Users</li>
                <li data-section="analytics"><i class="fas fa-chart-bar"></i>Analytics</li>
                <li data-section="settings"><i class="fas fa-cog"></i>Settings</li>
                <li onclick="logout()"><i class="fas fa-sign-out-alt"></i>Logout</li>
            </ul>
        </aside>

        <main class="main-content">
            <!-- Find this section in your code -->
            <div id="dashboard" class="content-section active">
                <!-- Add code -->

                <!-- Add this sensor registration form -->
                <div class="card">
                    <h3>Sensor Registration</h3>
                    <div style="padding: 1.5rem;">
                        <form action="/sensor-register" method="POST"  id="sensorForm">
                           @csrf
                            <div style="margin-bottom: 1.5rem;">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Location Name*</label>
                                <input name="location" type="text" placeholder="Location Name" required
                                    style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
                            </div>
                            
                            <div style="margin-bottom: 1.5rem;">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Map Location*</label>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                                    <input name="long" type="text" placeholder="Latitude" value="6.906464963229004" 
                                        style="padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
                                    <input name="lat" type="text" placeholder="Longitude" value="79.8708305568695" 
                                        style="padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
                                </div>
                            </div>

                            <button type="submit" style="width: 100%; padding: 1rem; background: #667eea; color: white; border: none; border-radius: 0.5rem; cursor: pointer;">Register Sensor</button>
                        </form>
                    </div>
                </div>

                <div style="height: 20px; width: 100%;"></div>

                <!-- Existing cards and chart -->
                <div class="card-container">
                    <div class="card">
                        <h3>Total Sensors</h3>
                        <p>2,543</p>
                    </div>
                    <div class="card">
                        <h3>Active Devices</h3>
                        <p>1,892</p>
                    </div>
                    <div class="card">
                        <h3>Recent Alerts</h3>
                        <p>24</p>
                    </div>
                </div>
            </div>

            
            <div id="users" class="content-section">
                <div class="card">
                    <h3>User Management</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td>Admin</td>
                                <td>Active</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="analytics" class="content-section">
                <div class="card">
                    <h3>Advanced Analytics</h3>
                    <canvas id="analyticsChart"></canvas>
                </div>
            </div>

            <div id="settings" class="content-section">
                <div class="card">
                    <h3>System Settings</h3>
                    <form class="settings-form">
                        <div class="input-group">
                            <label>Theme Color</label>
                            <input type="color" value="#667eea">
                        </div>
                        <div class="input-group">
                            <label>Notifications</label>
                            <input type="checkbox" checked>
                        </div>
                        <button type="submit" class="login-btn">Save Settings</button>
                    </form>
                </div>
            </div>
        </main>
    </div>


<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="../js/script.js"></script>
</body>
</html>