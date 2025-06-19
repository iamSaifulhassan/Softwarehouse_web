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
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
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
            grid-template-columns: 2fr 1fr;
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
            border-bottom: 2px solid #fed6e3;
            padding-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
        }

        .btn-create {
            background: #fed6e3;
            color: #333;
            width: 100%;
        }

        .btn-create:hover {
            background: #fec7d7;
        }

        .issue-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #fed6e3;
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

        .issue-status {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-new {
            background: #e3f2fd;
            color: #1976d2;
        }

        .status-assigned {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-in-progress {
            background: #fff9c4;
            color: #f57f17;
        }

        .status-completed {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .no-issues {
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
                <a href="/dashboard/requirements-analyst">Dashboard</a>
                <a href="/issues/create">Create Issue</a>
                <a href="/issues">All Issues</a>
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
                        <select id="priority" name="priority" required>
                            <option value="">Select Priority</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-create">Create Issue</button>
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
                            <div class="issue-status status-{{ str_replace('_', '-', $issue->status) }}">
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
