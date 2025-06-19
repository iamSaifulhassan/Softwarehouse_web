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
            background: linear-gradient(135deg,rgb(4, 22, 41),rgb(2, 53, 104));
            min-height: 100vh;
            color: #183153;
        }
        .navbar {
            background: rgb(1, 19, 37);
            border-bottom: 1px solid rgb(255, 255, 255);
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
            background: rgba(218, 218, 218, 0.06);
            color: #fff;
        }
        .nav-links a.active {
            background: rgba(255, 255, 255, 0.1);
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
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            text-align: center;
            border: 1px solid rgb(0, 0, 0);
            box-shadow: 0 4px 24px rgba(44, 62, 80, 0.06);
        }
        .welcome-title {
            color:rgb(0, 0, 0);
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .welcome-text {
            color:rgb(56, 50, 50);
            font-size: 1.15rem;
        }
        .tasks-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem 1.5rem;
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.06);
            border: 1px solid #e3eafc;
        }
        .section-title {
            color:rgb(1, 19, 37);
            font-size: 1.4rem;
            margin-bottom: 1.2rem;
            border-bottom: 2px solid rgb(1, 19, 37);
            padding-bottom: 0.5rem;
            font-weight: bold;
        }
        .task-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem 1rem;
            margin-bottom: 1.2rem;
            border-left: 4px solid rgb(80, 2, 2);
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.03);
        }
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .task-title {
            font-size: 1.15rem;
            font-weight: bold;
            color: #2d3a4a;
        }
        .task-priority {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
            background: #e3eafc;
            color: #2d3a4a;
        }
        .task-description {
            color: black;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        .task-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: black;
            font-size: 0.98rem;
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
            transition: background 0.3s, color 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
        }
        .btn-start {
            background:rgb(32, 46, 65);
            color: #fff;
        }
        .btn-start:hover {
            background:rgb(71, 74, 76);
            color: #fff;
        }
        .btn-complete {
            background:rgb(32, 65, 46);
            color: #fff;
        }
        .btn-complete:hover {
            background:rgb(71, 76, 74);
            color: #fff;
        }
        .no-tasks {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 2rem 0;
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
            border: 1px solid rgb(1, 19, 37);
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
            border: 1.5px solid rgb(1, 19, 37);
            box-shadow: 0 0 0 2px #b2ebf2;
            background: #fff;
        }
        @media (max-width: 900px) {
            .main-container {
                padding: 0 0.5rem;
            }
            .tasks-card, .welcome-card {
                padding: 1rem 0.5rem;
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
                <a href="/profile?username={{ isset($user) ? $user->username : (isset($issues[0]->assignedTo) ? $issues[0]->assignedTo->username : '') }}" class="{{ request()->is('profile*') ? 'active' : '' }}">Profile</a>
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
            @if(session('error'))
                <div class="error-message">{{ session('error') }}</div>
            @endif
            @if(isset($issues) && count($issues) > 0)
                @foreach($issues as $issue)
                <div class="task-item">
                    <div class="task-header">
                        <div class="task-title">{{ $issue->title }}</div>
                        <div class="task-priority">
                            {{ ucfirst($issue->priority) }} Priority
                        </div>
                    </div>
                    <div class="task-description">
                        {{ $issue->description }}
                    </div>
                    <div class="task-meta">
                        <span>Status: {{ ucfirst($issue->status) }}</span>
                        <div class="task-actions">
                            @if($issue->status == 'assigned')
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
