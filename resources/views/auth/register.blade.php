<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Software House</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            color: #183153;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
        }

        .register-card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.06);
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header h2 {
            color:rgb(0, 0, 0);
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .register-header p {
            color:rgb(56, 50, 50);
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border: 1px solid #ffcdd2;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #fed6e3;
            box-shadow: 0 0 5px rgba(254, 214, 227, 0.5);
        }

        .register-btn {
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

        .register-btn:hover {
            background: rgb(71, 74, 76);
            color: #fff;
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            color: rgb(2, 53, 104);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">            <div class="register-header">
                <h2>Join Software House</h2>
                <p>Create your account to get started</p>
            </div>
            
            @if(session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif
            
            <form method="POST" action="/register" class="register-form">
                @csrf
                <div class="input-group">
                    <label for="full_name">Full Name *</label>
                    <input type="text" id="full_name" name="full_name" required 
                           placeholder="Enter your full name" minlength="2" maxlength="100">
                </div>
                
                <div class="input-group">
                    <label for="username">Username *</label>
                    <input type="text" id="username" name="username" required 
                           placeholder="Choose a unique username" minlength="3" maxlength="50">
                </div>
                
                <div class="input-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" required 
                           placeholder="Enter your email address">
                </div>
                
                <div class="input-group">
                    <label for="password">Password *</label>
                    <div style="position:relative;">
                        <input type="password" id="password" name="password" required 
                               placeholder="At least 6 characters" minlength="6" style="padding-right:40px;">
                        <span onclick="togglePassword('password', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;">
                            <svg id="eye-icon1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </span>
                    </div>
                </div>
                <div class="input-group">
                    <label for="password_confirmation">Confirm Password *</label>
                    <div style="position:relative;">
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                               placeholder="Re-enter your password" minlength="6" style="padding-right:40px;">
                        <span onclick="togglePassword('password_confirmation', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;">
                            <svg id="eye-icon2" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </span>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="role">Your Role *</label>
                    <select id="role" name="role" required>
                        <option value="">Select your role</option>
                        <option value="requirement_gatherer">Requirements Analyst</option>
                        <option value="developer">Software Developer</option>
                        <option value="qa_specialist">Quality Assurance</option>
                        <option value="team_lead">Team Leader</option>
                    </select>
                </div>
                
                <button type="submit" class="register-btn">
                    Create Account
                </button>
            </form>
            
            <div class="register-footer">
                <p>Already have an account? <a href="/login">Sign in here</a></p>
            </div>
        </div>
    </div>
    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
                el.querySelector('svg').style.opacity = 0.5;
            } else {
                input.type = 'password';
                el.querySelector('svg').style.opacity = 1;
            }
        }
    </script>
</body>
</html>
