<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            width: 400px;
            animation: loginEnter 0.6s ease;
        }

        @keyframes loginEnter {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .login-btn {
            width: 100%;
            padding: 0.8rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .login-btn:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <form class="login-box" action="admin-dashboard.php">
        <div class="login-header">
            <h1>Admin Login</h1>
            <p>Access your dashboard</p>
        </div>
        <div class="input-group">
            <input type="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <input type="password" placeholder="Password" required>
        </div>
        <button type="submit" class="login-btn">Sign In</button>
    </form>
</body>
</html>