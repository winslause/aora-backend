<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora Admin - Authentication</title>
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5efe8 0%, #e8dfd5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Elements - Luxury Skeuomorphic */
        .bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><filter id="noise"><feTurbulence type="fractalNoise" baseFrequency="0.45" numOctaves="1" stitchTiles="stitch"/><feColorMatrix type="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 0.03 0"/></filter><rect width="100" height="100" filter="url(%23noise)" opacity="0.2"/></svg>');
            pointer-events: none;
            opacity: 0.15;
            z-index: 1;
        }

        .auth-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            margin: 1.5rem;
        }

        /* Glassmorphic Card with Skeuomorphic Touches */
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(184, 154, 120, 0.2);
            border-radius: 32px;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(184, 154, 120, 0.1) inset,
                0 2px 4px rgba(255, 255, 255, 0.5) inset;
            padding: 2.5rem;
            transition: all 0.3s ease;
        }

        .auth-card:hover {
            box-shadow: 
                0 30px 60px -12px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(184, 154, 120, 0.2) inset,
                0 2px 4px rgba(255, 255, 255, 0.6) inset;
        }

        /* Logo Area */
        .logo-area {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(145deg, #b89a78, #8a735b);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 
                0 10px 20px -5px rgba(184, 154, 120, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.3) inset,
                0 -2px 4px rgba(0, 0, 0, 0.1) inset;
        }

        .logo-icon span {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .logo-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 600;
            color: #3f352e;
            letter-spacing: 0.02em;
            margin-bottom: 0.25rem;
        }

        .logo-text p {
            color: #8a7a6a;
            font-size: 0.9rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
        }

        /* Form Elements */
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .input-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #4b3f35;
            margin-bottom: 0.5rem;
            letter-spacing: 0.02em;
        }

        .input-field {
            width: 100%;
            padding: 1rem 1.25rem 1rem 3rem;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid #e8dfd5;
            border-radius: 16px;
            font-size: 0.95rem;
            color: #2d241c;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02) inset;
        }

        .input-field:focus {
            outline: none;
            border-color: #b89a78;
            background: white;
            box-shadow: 0 0 0 4px rgba(184, 154, 120, 0.1);
        }

        .input-field::placeholder {
            color: #b8a99a;
            font-weight: 300;
        }

        .input-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #b89a78;
            font-size: 1.1rem;
            z-index: 1;
        }

        /* Password visibility toggle */
        .password-toggle {
            position: absolute;
            right: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #b8a99a;
            cursor: pointer;
            transition: color 0.2s ease;
            z-index: 1;
        }

        .password-toggle:hover {
            color: #b89a78;
        }

        /* Remember me & Forgot password */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #b89a78;
            border-radius: 4px;
            cursor: pointer;
        }

        .remember-me span {
            color: #5c524a;
            font-size: 0.9rem;
        }

        .forgot-link {
            color: #b89a78;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .forgot-link:hover {
            color: #8a735b;
            text-decoration: underline;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(145deg, #b89a78, #9b7e60);
            border: none;
            border-radius: 16px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 
                0 8px 16px -6px rgba(184, 154, 120, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.2) inset,
                0 -2px 4px rgba(0, 0, 0, 0.1) inset;
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            background: linear-gradient(145deg, #a88b6d, #8a735b);
            transform: translateY(-2px);
            box-shadow: 
                0 12px 20px -8px rgba(184, 154, 120, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.3) inset,
                0 -2px 4px rgba(0, 0, 0, 0.1) inset;
        }

        .login-btn:active {
            transform: translateY(2px);
            box-shadow: 
                0 4px 8px -4px rgba(184, 154, 120, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.2) inset,
                0 -1px 2px rgba(0, 0, 0, 0.1) inset;
        }

        .login-btn i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        /* Reset Password Section (initially hidden) */
        .reset-section {
            display: none;
        }

        .reset-section.active {
            display: block;
        }

        .login-section {
            display: block;
        }

        .login-section.hidden {
            display: none;
        }

        /* Back to login link */
        .back-to-login {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-to-login a {
            color: #8a7a6a;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .back-to-login a:hover {
            color: #b89a78;
        }

        .back-to-login a i {
            font-size: 0.8rem;
        }

        /* Reset success message */
        .reset-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #065f46;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .reset-success i {
            font-size: 1.2rem;
        }

        /* Error message */
        .error-message {
            background: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            color: #991b1b;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message i {
            font-size: 1rem;
        }

        /* Loading state */
        .loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Admin hint (demo only) */
        .demo-hint {
            margin-top: 1.5rem;
            padding: 0.75rem;
            background: rgba(184, 154, 120, 0.1);
            border-radius: 12px;
            border: 1px dashed rgba(184, 154, 120, 0.3);
            font-size: 0.8rem;
            color: #6b5d51;
            text-align: center;
        }

        .demo-hint i {
            color: #b89a78;
            margin-right: 0.25rem;
        }

        /* Decorative elements */
        .decor-circle {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(184, 154, 120, 0.1) 0%, rgba(184, 154, 120, 0) 70%);
            z-index: 0;
        }

        .decor-circle-1 {
            top: -150px;
            right: -100px;
        }

        .decor-circle-2 {
            bottom: -150px;
            left: -100px;
        }
    </style>
</head>
<body>
    <!-- Decorative Background Elements -->
    <div class="bg-pattern"></div>
    <div class="decor-circle decor-circle-1"></div>
    <div class="decor-circle decor-circle-2"></div>

    <!-- Main Auth Container -->
    <div class="auth-container">
        <!-- Auth Card -->
        <div class="auth-card">
            <!-- Logo Area -->
            <div class="logo-area">
                <div class="logo-icon">
                    <span>A</span>
                </div>
                <div class="logo-text">
                    <h1>Aora Admin</h1>
                    <p>Luxury Resort & Restaurant</p>
                </div>
            </div>

            <!-- Login Section -->
            <div id="loginSection" class="login-section">
                <!-- Error message placeholder (hidden by default) -->
                <div id="loginError" class="error-message" style="display: none;">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Invalid email or password. Please try again.</span>
                </div>

                <form id="loginForm" onsubmit="handleLogin(event)">
                    <!-- Email Input -->
                    <div class="input-group">
                        <label class="input-label">Email Address</label>
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="input-field" placeholder="admin@aora.com" id="email" value="admin@aora.com" required>
                    </div>

                    <!-- Password Input -->
                    <div class="input-group">
                        <label class="input-label">Password</label>
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="input-field" placeholder="••••••••" id="password" value="admin123" required>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword()" id="togglePassword"></i>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" checked>
                            <span>Remember me</span>
                        </label>
                        <a class="forgot-link" onclick="showResetSection()">Forgot password?</a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="login-btn" id="loginBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In to Dashboard
                    </button>
                </form>

                <!-- Demo Hint (remove in production) -->
                <div class="demo-hint">
                    <i class="fas fa-info-circle"></i>
                    Demo credentials: admin@aora.com / admin123
                </div>
            </div>

            <!-- Reset Password Section (initially hidden) -->
            <div id="resetSection" class="reset-section">
                <!-- Success message (hidden by default) -->
                <div id="resetSuccess" class="reset-success" style="display: none;">
                    <i class="fas fa-check-circle"></i>
                    <span>Password reset link has been sent to your email.</span>
                </div>

                <!-- Error message (hidden by default) -->
                <div id="resetError" class="error-message" style="display: none;">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Email not found. Please check and try again.</span>
                </div>

                <form id="resetForm" onsubmit="handleReset(event)">
                    <div class="input-group">
                        <label class="input-label">Email Address</label>
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="input-field" placeholder="admin@aora.com" id="resetEmail" required>
                    </div>

                    <button type="submit" class="login-btn" id="resetBtn">
                        <i class="fas fa-paper-plane"></i>
                        Send Reset Link
                    </button>
                </form>

                <!-- Back to Login Link -->
                <div class="back-to-login">
                    <a onclick="showLoginSection()">
                        <i class="fas fa-arrow-left"></i>
                        Back to Sign In
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="text-center text-sm text-[#8a7a6a] mt-4">
            <i class="far fa-copyright mr-1"></i>
            2026 Aora Luxury Resort. All rights reserved.
        </p>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Show Reset Password Section
        function showResetSection() {
            document.getElementById('loginSection').classList.add('hidden');
            document.getElementById('resetSection').classList.add('active');
            
            // Hide any messages
            document.getElementById('resetSuccess').style.display = 'none';
            document.getElementById('resetError').style.display = 'none';
            
            // Clear reset email
            document.getElementById('resetEmail').value = '';
        }

        // Show Login Section
        function showLoginSection() {
            document.getElementById('loginSection').classList.remove('hidden');
            document.getElementById('resetSection').classList.remove('active');
            
            // Hide login error
            document.getElementById('loginError').style.display = 'none';
        }

        // Handle Login
        function handleLogin(event) {
            event.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const loginBtn = document.getElementById('loginBtn');
            const errorMsg = document.getElementById('loginError');
            
            // Simple validation (demo purposes)
            if (email === 'admin@aora.com' && password === 'admin123') {
                // Show loading state
                loginBtn.classList.add('loading');
                
                // Simulate API call
                setTimeout(() => {
                    loginBtn.classList.remove('loading');
                    // Redirect to admin dashboard
                    window.location.href = 'admin-dashboard.html';
                }, 1000);
            } else {
                // Show error message
                errorMsg.style.display = 'flex';
                
                // Shake animation for error
                document.querySelector('.auth-card').style.animation = 'shake 0.5s ease';
                setTimeout(() => {
                    document.querySelector('.auth-card').style.animation = '';
                }, 500);
            }
        }

        // Handle Reset Password
        function handleReset(event) {
            event.preventDefault();
            
            const email = document.getElementById('resetEmail').value;
            const resetBtn = document.getElementById('resetBtn');
            const successMsg = document.getElementById('resetSuccess');
            const errorMsg = document.getElementById('resetError');
            
            // Hide both messages initially
            successMsg.style.display = 'none';
            errorMsg.style.display = 'none';
            
            // Show loading state
            resetBtn.classList.add('loading');
            
            // Simulate API call
            setTimeout(() => {
                resetBtn.classList.remove('loading');
                
                // Demo validation
                if (email === 'admin@aora.com') {
                    successMsg.style.display = 'flex';
                    
                    // Clear input
                    document.getElementById('resetEmail').value = '';
                    
                    // Auto hide success after 5 seconds
                    setTimeout(() => {
                        successMsg.style.display = 'none';
                    }, 5000);
                } else {
                    errorMsg.style.display = 'flex';
                }
            }, 1000);
        }

        // Add shake animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                20%, 40%, 60%, 80% { transform: translateX(5px); }
            }
        `;
        document.head.appendChild(style);

        // Handle Enter key for forms
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                if (document.getElementById('resetSection').classList.contains('active')) {
                    handleReset(e);
                } else {
                    handleLogin(e);
                }
            }
        });

        // Auto-focus email field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
        });
    </script>
</body>
</html>