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
            background: linear-gradient(135deg,rgb(4, 22, 41),rgb(2, 53, 104));
            min-height: 100vh;
            color: #183153;
        }
        .navbar {
            background: #183153;
            border-bottom: 1px solid #1976d2;
            padding: 1.2rem 2rem;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.04);
        }
        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        .logo {
            color: #fff;
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        .nav-links a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s, color 0.3s;
        }
        .nav-links a:hover {
            background: #1976d2;
            color: #fff;
        }
        .nav-links a.active {
            background: #1976d2;
            color: #fff;
        }
        .main-container {
            max-width: 1200px;
            margin: 2.5rem auto;
            padding: 0 2rem;
            display: grid;
            gap: 2rem;
        }
        .welcome-card {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 2.5rem 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 24px rgba(102, 126, 234, 0.08);
        }
        .welcome-title {
            color: #fff;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .welcome-text {
            color: rgba(255, 255, 255, 0.92);
            font-size: 1.15rem;
        }
        .tasks-card {
            background: #fff;
            border-radius: 18px;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 24px rgba(102, 126, 234, 0.08);
        }
        .section-title {
            color: #183153;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #1976d2;
            padding-bottom: 0.5rem;
        }
        .task-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.2rem;
            border-left: 4px solid #1976d2;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.04);
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
            font-size: 0.95rem;
        }
        .task-actions {
            display: flex;
            gap: 0.5rem;
        }
        .btn {
            padding: 0.5rem 1.2rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background 0.3s, color 0.3s;
        }
        .btn-approve {
            background: #4caf50;
            color: #fff;
        }
        .btn-approve:hover {
            background: #45a049;
        }
        .btn-reject {
            background: #f44336;
            color: #fff;
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
        .error-message {
            color: #f44336;
            background: #ffebee;
            border: 1px solid #f44336;
            border-radius: 6px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .select-style {
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            border: 1px solid #1976d2;
            background: #f8f9fa;
            color: #183153;
            font-size: 1rem;
            font-family: inherit;
            margin-right: 0.5rem;
            transition: border 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.04);
            outline: none;
        }
        .select-style:focus {
            border: 1.5px solid #183153;
            box-shadow: 0 0 0 2px #b2ebf2;
            background: #fff;
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
                <a href="/dashboard/qa-specialist" class="{{ request()->is('dashboard/qa-specialist') ? 'active' : '' }}">Dashboard</a>
                <a href="/issues" class="{{ request()->is('issues') ? 'active' : '' }}">All Issues</a>
                <a href="/profile?username={{ isset($user) ? $user->username : (isset($testingTasks[0]->assignedTo) ? $testingTasks[0]->assignedTo->username : '') }}" class="{{ request()->is('profile*') ? 'active' : '' }}">Profile</a>
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
            @if(session('error'))
                <div class="error-message">{{ session('error') }}</div>
            @endif
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
                                    @csrf
                                    <input type="hidden" name="issue_id" value="{{ $task->id }}">
                                    <button type="submit" class="btn btn-approve">Approve</button>
                                </form>
                                <form method="POST" action="/issues/reject" style="display: inline;">
                                    @csrf
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
