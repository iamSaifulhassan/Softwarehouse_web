<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QA Specialist Dashboard</title>
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
            border-bottom: 2px solid #764ba2;
            padding-bottom: 0.5rem;
        }

        .task-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #764ba2;
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

        .task-status {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-completed {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .status-testing {
            background: #fff3e0;
            color: #ef6c00;
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

        .btn-approve {
            background: #4caf50;
            color: white;
        }

        .btn-approve:hover {
            background: #45a049;
        }

        .btn-reject {
            background: #f44336;
            color: white;
        }

        .btn-reject:hover {
            background: #d32f2f;
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
                <a href="/dashboard/qa-specialist">Dashboard</a>
                <a href="/issues">Testing Queue</a>
                <a href="/logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="welcome-card">
            <h1 class="welcome-title">Welcome, QA Specialist!</h1>
            <p class="welcome-text">Review and test completed tasks for quality assurance.</p>
        </div>

        <div class="tasks-card">
            <h2 class="section-title">Tasks Ready for Testing</h2>
            
            @if(isset($testingTasks) && count($testingTasks) > 0)
                @foreach($testingTasks as $task)
                <div class="task-item">
                    <div class="task-header">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-status status-{{ str_replace('_', '-', $task->status) }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </div>
                    </div>
                    <div class="task-description">
                        {{ $task->description }}
                    </div>
                    <div class="task-meta">
                        <span>Developer: {{ $task->developer_name ?? 'Not assigned' }}</span>
                        <div class="task-actions">
                            @if($task->status == 'completed')
                                <form method="POST" action="/issues/approve" style="display: inline;">
                                    <input type="hidden" name="issue_id" value="{{ $task->id }}">
                                    <button type="submit" class="btn btn-approve">Approve</button>
                                </form>
                                <form method="POST" action="/issues/reject" style="display: inline;">
                                    <input type="hidden" name="issue_id" value="{{ $task->id }}">
                                    <button type="submit" class="btn btn-reject">Reject</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="no-tasks">
                    <p>No tasks ready for testing at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
