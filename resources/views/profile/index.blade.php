<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Software House</title>
    <style>
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
        .profile-container {
            max-width: 500px;
            margin: 3rem auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.06);
            padding: 2.5rem 2rem;
        }
        .profile-title {
            color: rgb(1, 19, 37);
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .profile-form label {
            font-weight: 500;
            color: #183153;
            margin-bottom: 0.3rem;
            display: block;
        }
        .profile-form input, .profile-form select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e3eafc;
            border-radius: 6px;
            font-size: 1rem;
            margin-bottom: 1.2rem;
        }
        .profile-form button {
            width: 100%;
            padding: 0.75rem;
            background: rgb(1, 19, 37);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, color 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
        }
        .profile-form button:hover {
            background: rgb(71, 74, 76);
        }
        .delete-btn {
            background: linear-gradient(90deg, #c62828 0%, #a31515 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            width: 100%;
            padding: 0.75rem;
            margin-top: 1.2rem;
            box-shadow: 0 2px 8px rgba(198, 40, 40, 0.10);
            transition: background 0.3s, box-shadow 0.3s;
        }
        .delete-btn:hover {
            background: linear-gradient(90deg, #a31515 0%, #c62828 100%);
            box-shadow: 0 4px 16px rgba(198, 40, 40, 0.18);
        }
        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border: 1px solid #c8e6c9;
            text-align: center;
        }
        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border: 1px solid #ffcdd2;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">Software House</div>
            <div class="nav-links">
                <a href="/dashboard/{{ $user->role == 'requirement_gatherer' ? 'requirements-analyst' : ($user->role == 'developer' ? 'developer' : ($user->role == 'qa_specialist' ? 'qa-specialist' : 'team-lead')) }}">Dashboard</a>
                <a href="/issues">All Issues</a>
                <a href="/profile?username={{ $user->username }}">Profile</a>
                <a href="/logout">Logout</a>
            </div>
        </div>
    </nav>
    <div class="profile-container">
        <div class="profile-title">My Profile</div>
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif
        <form class="profile-form" method="POST" action="/profile/update">
            @csrf
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="{{ $user->full_name }}" required>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ $user->username }}" required readonly style="background:#f3f3f3; cursor:not-allowed;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" required>
            <label for="role">Role</label>
            <select id="role" name="role" disabled>
                <option value="requirement_gatherer" @if($user->role=='requirement_gatherer') selected @endif>Requirements Analyst</option>
                <option value="developer" @if($user->role=='developer') selected @endif>Software Developer</option>
                <option value="qa_specialist" @if($user->role=='qa_specialist') selected @endif>Quality Assurance</option>
                <option value="team_lead" @if($user->role=='team_lead') selected @endif>Team Leader</option>
            </select>
            <label for="password">Change Password</label>
            <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
            <button type="submit">Update Profile</button>
        </form>
        <form method="POST" action="/profile/delete" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
            @csrf
            <input type="hidden" name="username" value="{{ $user->username }}">
            <input type="hidden" name="email" value="{{ $user->email }}">
            <button type="submit" class="delete-btn">Delete My Account</button>
        </form>
    </div>
</body>
</html>
