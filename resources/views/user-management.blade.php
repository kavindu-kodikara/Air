<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: var(--dark);
            line-height: 1.6;
        }

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

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .dashboard-header {
            margin-bottom: 2rem;
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

        .card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 1.8rem;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow-x: auto;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            font-size: 0.95rem;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        th {
            background-color: var(--primary);
            color: var(--white);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
        }

        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.7rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-active {
            background-color: rgba(56, 176, 0, 0.1);
            color: var(--success);
        }

        .status-inactive {
            background-color: rgba(239, 35, 60, 0.1);
            color: var(--danger);
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
            background-color: var(--success);
            color: var(--white);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .action-btn i {
            font-size: 0.8rem;
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
            
            .container {
                padding: 0 1rem;
            }
            
            .dashboard-title {
                font-size: 1.8rem;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body >
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container" style="display: flex;flex-direction: row;width: 100%">
            <div style="width: 50%;">
                <a href="#" class="logo">
                    <i class="fas fa-wind"></i>
                    Admistator Dashboard
                </a>
            </div>
            <div style="width: 50%;display: flex;justify-content: flex-end">
                <a href="#" class="logo">
                    <i class="fa-solid fa-right-from-bracket" onclick="adminLogout();"></i>
                </a>
            </div>
            
            
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">User Management</h1>
            <p class="dashboard-subtitle">Manage system users and their access</p>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Registered Users</h2>
                <div class="status-bar">{{ count($admins) }} users found</div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td >{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            
                            <td>
                                @if ($user['status']==1)
                                    <button class="action-btn btn-unblock" onclick="userStatus({{$user['id']}},0)" >
                                        <i class="fas fa-lock-open"></i>
                                        Active
                                    </button>
                                    @else
                                    
                                    <button class="action-btn btn-block"  onclick="userStatus({{$user['id']}},1)">
                                        <i class="fas fa-lock"></i>
                                        Deactive
                                    </button>
                                    @endif
                            </td>
                            <td>
                                <button class="action-btn"  onclick="window.location='/user-dashboard?id={{ $user['id'] }}'">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Your existing modal code if needed
        });

        function toggleStatus(button, userId) {
            const isCurrentlyActive = button.classList.contains('btn-block');
            const newStatus = isCurrentlyActive ? 'inactive' : 'active';
            const action = isCurrentlyActive ? 'block' : 'unblock';
            
            if (confirm(`Are you sure you want to ${action} this user?`)) {
                // Send request to server
                fetch(`/admin/users/${userId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to update user status');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update button appearance
                    if (newStatus === 'active') {
                        button.innerHTML = '<i class="fas fa-lock"></i> Block';
                        button.classList.remove('btn-unblock');
                        button.classList.add('btn-block');
                        
                        // Update status badge
                        const statusBadge = button.closest('tr').querySelector('.status-badge');
                        statusBadge.textContent = 'active';
                        statusBadge.classList.remove('status-inactive');
                        statusBadge.classList.add('status-active');
                    } else {
                        button.innerHTML = '<i class="fas fa-lock-open"></i> Unblock';
                        button.classList.remove('btn-block');
                        button.classList.add('btn-unblock');
                        
                        // Update status badge
                        const statusBadge = button.closest('tr').querySelector('.status-badge');
                        statusBadge.textContent = 'inactive';
                        statusBadge.classList.remove('status-active');
                        statusBadge.classList.add('status-inactive');
                    }
                    
                    // Show success message
                    alert(`User ${action}ed successfully`);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update user status. Please try again.');
                });
            }
        }
    </script>
    <script src="../js/script.js"></script>
</body>
</html>