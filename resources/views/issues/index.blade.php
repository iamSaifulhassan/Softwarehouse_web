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
        .main-container {
            max-width: 1200px;
            margin: 2.5rem auto;
            padding: 0 2rem;
            display: grid;
            gap: 2rem;
        }
        .page-header {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            text-align: center;
            border: 1px solid rgb(0, 0, 0);
            box-shadow: 0 4px 24px rgba(44, 62, 80, 0.06);
        }
        .page-title {
            color:rgb(0, 0, 0);
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .issues-card {
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
        .issue-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .issue-title {
            font-size: 1.15rem;
            font-weight: bold;
            color: #2d3a4a;
            margin-bottom: 0.4rem;
        }
        .issue-status {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
            display: inline-block;
        }
        .status-approved {
            background: #e8f5e8;
            color: #2e7d32;
        }
        .status-new {
            background: #e3f2fd;
            color: #0a2342;
        }
        .status-in-progress {
            background: #fff3e0;
            color: #ef6c00;
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
        .no-issues {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 2rem 0;
        }
        @media (max-width: 900px) {
            .main-container {
                padding: 0 0.5rem;
            }
            .issues-card, .page-header {
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
                <a href="/dashboard">Dashboard</a>
                <a href="/issues">All Issues</a>
                <a href="/logout">Logout</a>
            </div>
        </div>
    </nav>
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">All Issues</h1>
            <p style="color: rgb(56, 50, 50);">Project issues and their current status</p>
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
