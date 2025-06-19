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
            background: linear-gradient(135deg,rgb(4, 22, 41),rgb(2, 53, 104));
            min-height: 100vh;
            color: #183153;
        }
        .navbar {
            background: rgb(1, 19, 37);
            border-bottom: 1px solidrgb(255, 255, 255);
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
            transition: background 
            0.3s, color 0.3s;
        }
        .nav-links a:hover {
            background: rgba(218, 218, 218, 0.06);
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
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        .card {
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
        .issue-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem 1rem;
            margin-bottom: 1.2rem;
            border-left: 4px solid rgb(80, 2, 2);
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.03);
        }
        .issue-title {
            padding: 0.5rem 1.2rem;
            font-size: 1.15rem;
            font-weight: bold;
            color: #2d3a4a;
            margin-bottom: 0.4rem;
        }
        .issue-description {
            font-size: 1rem;
            padding: 0.5rem 1.2rem;
            color: black;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        .issue-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: black;
            font-size: 0.98rem;
        }
        .btn {
            padding: 0.5rem 1.2rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background 0.3s,
             color 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
        }
        .btn-assign {
            background: linear-gradient(90deg, rgb(2, 53, 104) 0%, rgb(32, 46, 65) 100%);
            color: #fff;
            font-weight: 600;
            border: none;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.10);
            letter-spacing: 0.5px;
        }
        .btn-assign:hover {
            background: linear-gradient(90deg, rgb(1, 19, 37) 0%, rgb(71, 74, 76) 100%);
            color: #fff;
            box-shadow: 0 4px 16px rgba(2, 53, 104, 0.12);
        }
        .developer-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.2rem 1rem;
            margin-bottom: 0.8rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.03);
        }
        .developer-name {
            font-weight: bold;
            color: #2d3a4a;
            font-size: 1.08rem;
        }
        .developer-status {
            font-size: 0.98rem;
            color: #666;
        }
        .no-items {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 2rem 0;
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
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 600px) {
            .main-container {
                padding: 0 0.5rem;
            }
            .card, .welcome-card {
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
                <a href="/dashboard/team-lead" class="{{ request()->is('dashboard/team-lead') ? 'active' : '' }}">Dashboard</a>
                <a href="/issues" class="{{ request()->is('issues') ? 'active' : '' }}">All Issues</a>
                <a href="/team" class="{{ request()->is('team') ? 'active' : '' }}">My Team</a>
                <a href="/profile?username={{ isset($user) ? $user->username : (isset($teamMembers[0]) ? $teamMembers[0]->username : '') }}" class="{{ request()->is('profile*') ? 'active' : '' }}">Profile</a>
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
                        <div class="issue-description">{{ $issue->description }}</div>
                        <div class="issue-meta">
                            <span>Priority: {{ ucfirst($issue->priority) }}</span>
                            <form method="POST" action="/issues/assign" style="display: inline;">
                                @csrf
                                <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                                <select name="developer_id" class = "select-style" required>
                                    <option value="">Select Developer</option>
                                    @if(isset($developers))
                                        @foreach($developers as $developer)
                                            <option value="{{ $developer->id }}">{{ $developer->full_name }}</option>
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
                            <div class="developer-name">{{ $member->full_name }}</div>
                            <div class="developer-status">{{ ucfirst($member->role) }}</div>
                        </div>
                        <div class="developer-status">
                            Active Tasks: {{ $member->active_tasks_count ?? 0 }}
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="no-items">
                        <p>No team members assigned yet. If you have no developers, please add developers to the system.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
