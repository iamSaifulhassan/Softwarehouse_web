<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Issues - Software House</title>
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
        }

        .page-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }

        .page-title {
            color: white;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .issues-card {
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

        .issue-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #764ba2;
        }

        .issue-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .issue-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
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

        .status-approved {
            background: #e8f5e8;
            color: #2e7d32;
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

        .no-issues {
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
                <a href="/dashboard">Dashboard</a>
                <a href="/issues">All Issues</a>
                <a href="/logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">All Issues</h1>
            <p style="color: rgba(255, 255, 255, 0.8);">Project issues and their current status</p>
        </div>

        <div class="issues-card">
            <h2 class="section-title">Project Issues</h2>
            
            @if(isset($issues) && count($issues) > 0)
                @foreach($issues as $issue)
                <div class="issue-item">
                    <div class="issue-header">
                        <div class="issue-title">{{ $issue->title }}</div>
                        <div class="issue-status status-{{ str_replace('_', '-', $issue->status) }}">
                            {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
                        </div>
                    </div>
                    <div class="issue-description">
                        {{ $issue->description }}
                    </div>
                    <div class="issue-meta">
                        <span>Priority: {{ ucfirst($issue->priority) }}</span>
                        <span>Created: {{ $issue->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                @endforeach
            @else
                <div class="no-issues">
                    <p>No issues found.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
