<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requirements Analyst Dashboard</title>
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
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #183153;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e3eafc;
            border-radius: 6px;
            font-size: 1rem;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .btn {
            padding: 0.5rem 1.2rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            background:rgb(32, 46, 65);
            color: #fff;
            transition: background 0.3s, color 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
        }
        .btn:hover {
            background:rgb(71, 74, 76);
            color: #fff;
        }
        /* --- Issue Card & Badge Polishing --- */
        .issue-item {
            background: #fff;
            border-radius: 18px;
            padding: 1.7rem 1.3rem 1.2rem 1.3rem;
            margin-bottom: 1.5rem;
            border-left: 6px solid #008080; /* Teal accent */
            box-shadow: 0 4px 18px rgba(2, 53, 104, 0.10);
            transition: box-shadow 0.2s;
        }
        .issue-item:hover {
            box-shadow: 0 8px 32px rgba(2, 53, 104, 0.18);
        }
        .issue-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #012b4d;
            margin-bottom: 0.3rem;
            letter-spacing: 0.5px;
        }
        .issue-description {
            font-size: 1.02rem;
            color: #183153;
            margin-bottom: 1.1rem;
            line-height: 1.6;
            padding: 0;
        }
        .issue-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #183153;
            font-size: 0.99rem;
        }
        .issue-status {
            display: inline-block;
            padding: 0.32rem 1.1rem;
            border-radius: 999px;
            font-size: 0.93rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-left: 0.5rem;
            box-shadow: 0 1px 4px rgba(2, 53, 104, 0.07);
        }
        .issue-status.status-approved {
            background: #1de9b6;
            color: #00332e;
        }
        .issue-status.status-new {
            background: #0d2240;
            color: #fff;
        }
        .issue-status.status-in-progress {
            background: #ffb300;
            color: #3d2c00;
        }
        .no-issues {
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
                <a href="/dashboard/requirements-analyst" class="{{ request()->is('dashboard/requirements-analyst') ? 'active' : '' }}">Dashboard</a>
                <a href="/issues/create" class="{{ request()->is('issues/create') ? 'active' : '' }}">Create Issue</a>
                <a href="/issues" class="{{ request()->is('issues') ? 'active' : '' }}">All Issues</a>
                <a href="/profile?username={{ isset($user) ? $user->username : (isset($recentIssues[0]->creator) ? $recentIssues[0]->creator->username : '') }}" class="{{ request()->is('profile*') ? 'active' : '' }}">Profile</a>
                <a href="/logout">Logout</a>
            </div>
        </div>
    </nav>
    <div class="main-container">
        <div class="welcome-card">
            <h1 class="welcome-title">Welcome, Requirements Analyst!</h1>
            <p class="welcome-text">Create and manage project requirements and issues.</p>
        </div>
        <div class="content-grid">
            <div class="card">
                <h2 class="section-title">Create New Issue</h2>
                @if(session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif
                <form method="POST" action="/issues/store">
                    @csrf
                    <div class="form-group">
                        <label for="title">Issue Title</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority" class="select-style" required>
                            <option value="">Select Priority</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Create Issue</button>
                </form>
            </div>
            <div class="card">
                <h2 class="section-title">Recent Issues</h2>
                @if(isset($recentIssues) && count($recentIssues) > 0)
                    @foreach($recentIssues as $issue)
                    <div class="issue-item">
                        <div class="issue-title">{{ $issue->title }}</div>
                        <div class="issue-description">{{ Str::limit($issue->description, 100) }}</div>
                        <div class="issue-meta">
                            <span>Priority: {{ ucfirst($issue->priority) }}</span>
                            @php
                                $statusClass = 'status-new';
                                if ($issue->status === 'approved') $statusClass = 'status-approved';
                                elseif ($issue->status === 'in_progress') $statusClass = 'status-in-progress';
                            @endphp
                            <div class="issue-status {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="no-issues">
                        <p>No issues created yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
