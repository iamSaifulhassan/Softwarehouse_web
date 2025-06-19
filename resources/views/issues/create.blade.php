<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Issue - Software House</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
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
            max-width: 600px;
            margin: 2.5rem auto;
            padding: 0 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem 2rem;
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
            text-align: left;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: 500;
            color: #183153;
            margin-bottom: 0.3rem;
            display: block;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1.5px solid #b2becd;
            border-radius: 6px;
            font-size: 1rem;
            margin-bottom: 1.2rem;
            background: #f8f9fa;
            transition: border 0.3s, box-shadow 0.3s;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border: 1.5px solid #1976d2;
            box-shadow: 0 0 0 2px #b2ebf2;
            background: #fff;
            outline: none;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .btn-create {
            background: rgb(1, 19, 37);
            color: #fff;
            width: 100%;
            font-weight: bold;
            border-radius: 8px;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
            transition: background 0.3s, color 0.3s;
            padding: 0.75rem 0;
            border: none;
        }

        .btn-create:hover {
            background: rgb(71, 74, 76);
            color: #fff;
        }

        @media (max-width: 600px) {
            .main-container {
                padding: 1rem 0.2rem;
            }
            .card {
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
                <a href="/dashboard/requirements-analyst">Dashboard</a>
                <a href="/issues">All Issues</a>
                <a href="/logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="card">
            <h2 class="section-title">Create New Issue</h2>
            <form method="POST" action="/issues/store">
                @csrf
                <div class="form-group">
                    <label for="title">Issue Title *</label>
                    <input type="text" id="title" name="title" required 
                           placeholder="Enter a clear and descriptive title"
                           minlength="5" maxlength="200">
                </div>
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" required 
                              placeholder="Provide detailed description of the requirement or issue"
                              minlength="10" maxlength="1000"></textarea>
                </div>
                <div class="form-group">
                    <label for="priority">Priority *</label>
                    <select id="priority" name="priority" required>
                        <option value="">Select Priority Level</option>
                        <option value="low">Low Priority</option>
                        <option value="medium">Medium Priority</option>
                        <option value="high">High Priority</option>
                    </select>
                </div>
                <button type="submit" class="btn-create">Create Issue</button>
            </form>
        </div>
    </div>
</body>
</html>
