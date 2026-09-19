<!DOCTYPE html>
<html>
<head>
    <title>NutriTrack - Welcome</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
           
            background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 50%, #415a77 100%); 
            background-attachment: fixed;
            color: #e0e1dd; 
            text-align: center; 
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container { 
            width: 100%;
            max-width: 400px; 
            margin: 20px; 
            
            background: rgba(255, 255, 255, 0.07); 
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 40px 30px; 
            border-radius: 28px; 
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35); 
            border: 1px solid rgba(255, 255, 255, 0.12); 
            box-sizing: border-box;
        }

        h2 { 
           
            color: #00f5d4; 
            font-size: 36px;
            font-weight: 800;
            margin-top: 0;
            margin-bottom: 25px; 
            letter-spacing: -0.5px;
            text-shadow: 0 0 15px rgba(0, 245, 212, 0.3);
        }

        input { 
            width: 100%; 
            padding: 14px; 
            margin: 10px 0; 
            border: 1px solid rgba(255, 255, 255, 0.15); 
            border-radius: 12px; 
            box-sizing: border-box; 
            font-size: 14px; 
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            transition: all 0.3s ease;
        }
        
        input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        input:focus {
            outline: none;
           
            border-color: #00b4d8;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 12px rgba(0, 180, 216, 0.4);
        }

        button { 
            width: 100%; 
            padding: 14px; 
           
            background: linear-gradient(135deg, #00b4d8, #00f5d4); 
            color: #0d1b2a; 
            border: none; 
            border-radius: 12px; 
            font-weight: 800; 
            cursor: pointer; 
            font-size: 16px; 
            margin-top: 15px; 
            box-shadow: 0 5px 15px rgba(0, 245, 212, 0.25);
            transition: all 0.3s ease;
        }
        
        button:hover { 
            background: linear-gradient(135deg, #00f5d4, #00b4d8); 
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 245, 212, 0.45);
        }

        button:active {
            transform: translateY(1px);
        }

        .toggle-text { margin-top: 20px; font-size: 14px; color: #a4c3b2; }
        .toggle-text a { color: #00f5d4; text-decoration: none; font-weight: bold; cursor: pointer; transition: color 0.2s; }
        .toggle-text a:hover { color: #00b4d8; text-decoration: underline; }

        .divider { margin: 25px 0; color: #8892b0; font-size: 14px; display: flex; align-items: center; justify-content: center; font-weight: 600; }
        .divider::before, .divider::after { content: ""; flex: 1; background: rgba(255, 255, 255, 0.15); height: 1px; margin: 0 10px; }

        .google-btn-wrapper { display: flex; justify-content: center; margin-top: 15px; }
        #signup-form { display: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>NutriTrack</h2>

        <div id="login-box">
            <form action="login.php" method="POST">
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login_submit">Log In</button>
            </form>
            <div class="toggle-text">
                Don't have an account? <a onclick="toggleForms()">Sign Up </a>
            </div>
        </div>

        <div id="signup-form">
            <form action="login.php" method="POST">
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="New Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit" name="signup_submit">Create Account</button>
            </form>
            <div class="toggle-text">
                Already have an account? <a onclick="toggleForms()">Log In</a>
            </div>
        </div>

        <div class="divider">OR</div>
        
        <div class="google-btn-wrapper">
           
            <div id="g_id_onload"
                 data-client_id="7146553874-gf32k9eqp5vlgsmki9jjvhtbua42h0p3.apps.googleusercontent.com"
                 data-context="signin"
                 data-ux_mode="redirect"
                 data-login_uri="http://localhost/habit%20tracking/login.php"
                 data-auto_prompt="false">
            </div>

            <div class="g_id_signin"
                 data-type="standard"
                 data-shape="pill"
                 data-theme="filled_black"
                 data-text="signin_with"
                 data-size="large"
                 data-logo_alignment="left">
            </div>
        </div>
    </div>

    <script>
        function toggleForms() {
            const loginBox = document.getElementById('login-box');
            const signupBox = document.getElementById('signup-form');
            if (loginBox.style.display === 'none') {
                loginBox.style.display = 'block';
                signupBox.style.display = 'none';
            } else {
                loginBox.style.display = 'none';
                signupBox.style.display = 'block';
            }
        }
    </script>
</body>
</html>