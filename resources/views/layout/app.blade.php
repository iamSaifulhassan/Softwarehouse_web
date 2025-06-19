<!DOCTYPE html>
<html lang="en">
<head>
    <title>TechHub Solutions</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .header-nav {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .brand-logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        
        .menu-links {
            display: flex;
            gap: 2rem;
        }
        
        .menu-links a {
            text-decoration: none;
            color: #666;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .menu-links a:hover {
            color: #667eea;
        }
        
        .page-content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .content-box {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .action-btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-blue {
            background: #667eea;
            color: white;
        }
        
        .btn-blue:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
        
        .btn-green {
            background: #28a745;
            color: white;
        }
        
        .btn-yellow {
            background: #ffc107;
            color: #212529;
        }
        
        .btn-red {
            background: #dc3545;
            color: white;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }
        
        .text-input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e1e5e9;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .text-input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .data-table th,
        .data-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .data-table th {
            background: #f8f9fa;
            font-weight: 600;
        }
        
        .task-status {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-new { background: #e3f2fd; color: #1976d2; }
        .status-assigned { background: #fff3e0; color: #f57c00; }
        .status-inprogress { background: #e8f5e8; color: #388e3c; }
        .status-completed { background: #f3e5f5; color: #7b1fa2; }
        .status-testing { background: #fff8e1; color: #f9a825; }
        .status-approved { background: #e8f5e8; color: #2e7d32; }
        .status-rejected { background: #ffebee; color: #c62828; }
    </style>
</head>
<body>
    <nav class="header-nav">
        <div class="nav-wrapper">
            <div class="brand-logo">TechHub Solutions</div>
            <div class="menu-links">
                @if(session('user_id'))
                    <a href="/dashboard">Dashboard</a>
                    <a href="/logout">Logout</a>
                @else
                    <a href="/login">Login</a>
                    <a href="/register">Register</a>
                @endif
            </div>
        </div>
    </nav>
    
    <div class="page-content">
        @yield('content')
    </div>
</body>
</html>
