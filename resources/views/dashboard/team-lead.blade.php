<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Lead Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #f5576c;
            padding-bottom: 0.5rem;
        }

        .issue-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #f5576c;
        }

        .issue-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .issue-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .issue-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #888;
            font-size: 0.9rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
        }

        .btn-assign {
            background: #f5576c;
            color: white;
        }

        .btn-assign:hover {
            background: #e91e63;
        }

        .developer-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .developer-name {
            font-weight: bold;
            color: #333;
        }

        .developer-status {
            font-size: 0.9rem;
            color: #666;
        }

        .no-items {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
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
                <a href="/dashboard/team-lead">Dashboard</a>
                <a href="/issues">All Issues</a>
                <a href="/team">My Team</a>
                <a href="/logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="welcome-card">
            <h1 class="welcome-title">Welcome, Team Lead!</h1>
            <p class="welcome-text">Manage your team and assign tasks efficiently.</p>
        </div>

        <div class="content-grid">
            <div class="card">
                <h2 class="section-title">Unassigned Issues</h2>
                
                @if(isset($unassignedIssues) && count($unassignedIssues) > 0)
                    @foreach($unassignedIssues as $issue)
                    <div class="issue-item">
                        <div class="issue-title">{{ $issue->title }}</div>
                        <div class="issue-description">{{ $issue->description }}</div>                        <div class="issue-meta">
                            <span>Priority: {{ ucfirst($issue->priority) }}</span>
                            <form method="POST" action="/issues/assign" style="display: inline;">
                                <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                                <select name="developer_id" required>
                                    <option value="">Select Developer</option>
                                    @if(isset($developers))
                                        @foreach($developers as $developer)
                                            <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <button type="submit" class="btn btn-assign">Assign</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="no-items">
                        <p>No unassigned issues at the moment.</p>
                    </div>
                @endif
            </div>

            <div class="card">
                <h2 class="section-title">My Team</h2>
                
                @if(isset($teamMembers) && count($teamMembers) > 0)
                    @foreach($teamMembers as $member)
                    <div class="developer-item">
                        <div>
                            <div class="developer-name">{{ $member->name }}</div>
                            <div class="developer-status">{{ ucfirst($member->role) }}</div>
                        </div>
                        <div class="developer-status">
                            Active Tasks: {{ $member->active_tasks_count ?? 0 }}
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="no-items">
                        <p>No team members assigned yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
