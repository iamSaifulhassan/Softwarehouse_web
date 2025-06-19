<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Software House</title>
</head>
<body>
    <div class="login-container">
        <div class="login-card">            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Sign in to your account</p>
            </div>
            
            @if(session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif
            
            <form method="POST" action="/login" class="login-form">
                @csrf
                <div class="input-group">
                    <label for="username">Username *</label>
                    <input type="text" id="username" name="username" required 
                           placeholder="Enter your username" minlength="3">
                </div>
                
                <div class="input-group">
                    <label for="password">Password *</label>
                    <div style="position:relative;">
                        <input type="password" id="password" name="password" required 
                               placeholder="Enter your password" minlength="6" style="padding-right:40px;">
                        <span onclick="togglePassword('password', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </span>
                    </div>
                </div>
                
                <button type="submit" class="login-btn">
                    Sign In
                </button>
            </form>
            
            <div class="login-footer">
                <p>Don't have an account? <a href="/register">Create one here</a></p>
            </div>
        </div>
    </div>

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

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.06);
            width: 100%;
            max-width: 400px;
        }        .login-header {
            text-align: center;
            margin-bottom: 30px;
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

        .login-header h2 {
            color:rgb(0, 0, 0);
            margin-bottom: 8px;
            font-size: 28px;
            font-weight: 600;
        }

        .login-header p {
            color:rgb(56, 50, 50);
            font-size: 16px;
        }

        .login-form {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: rgb(1, 19, 37);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s, color 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
        }

        .login-btn:hover {
            background: rgb(71, 74, 76);
            color: #fff;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
        }

        .login-footer p {
            color: #666;
        }

        .login-footer a {
            color: rgb(2, 53, 104);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>

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
