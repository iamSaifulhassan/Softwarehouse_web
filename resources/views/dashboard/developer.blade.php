<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .main-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: grid;
            gap: 2rem;
        }

        .welcome-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .welcome-title {
            color: white;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .welcome-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        .tasks-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #4facfe;
            padding-bottom: 0.5rem;
        }

        .task-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #4facfe;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .task-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }

        .task-priority {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .priority-high {
            background: #ffebee;
            color: #c62828;
        }

        .priority-medium {
            background: #fff3e0;
            color: #ef6c00;
        }

        .priority-low {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .task-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .task-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #888;
            font-size: 0.9rem;
        }

        .task-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
        }

        .btn-start {
            background: #4facfe;
            color: white;
        }

        .btn-start:hover {
            background: #2196f3;
        }

        .btn-complete {
            background: #4caf50;
            color: white;
        }

        .btn-complete:hover {
            background: #45a049;
        }

        .no-tasks {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 2rem;
        }

        @media (max-width: 768px) {            
            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">Software House</div>
            <div class="nav-links">
                <a href="/dashboard/developer">Dashboard</a>
                <a href="/issues">My Tasks</a>
                <a href="/logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="welcome-card">
            <h1 class="welcome-title">Welcome, Developer!</h1>
            <p class="welcome-text">Here are your assigned tasks and project updates.</p>
        </div>

        <div class="tasks-card">
            <h2 class="section-title">My Active Tasks</h2>
            
            @if(isset($issues) && count($issues) > 0)
                @foreach($issues as $issue)
                <div class="task-item">
                    <div class="task-header">
                        <div class="task-title">{{ $issue->title }}</div>
                        <div class="task-priority priority-{{ strtolower($issue->priority) }}">
                            {{ ucfirst($issue->priority) }} Priority
                        </div>
                    </div>
                    <div class="task-description">
                        {{ $issue->description }}
                    </div>
                    <div class="task-meta">
                        <span>Status: {{ ucfirst($issue->status) }}</span>
                        <div class="task-actions">                            @if($issue->status == 'assigned')
                                <form method="POST" action="/issues/start" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                                    <button type="submit" class="btn btn-start">Start Work</button>
                                </form>
                            @elseif($issue->status == 'in_progress')
                                <form method="POST" action="/issues/complete" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                                    <button type="submit" class="btn btn-complete">Mark Complete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="no-tasks">
                    <p>No tasks assigned to you at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
