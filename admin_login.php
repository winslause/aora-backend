<?php
// Simple login handler that redirects to admin
// Check if session is already started before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin_login.php');
    exit;
}

// If already logged in, redirect to admin
if (isset($_SESSION['admin_id'])) {
    header('Location: admin.php');
    exit;
}

$error = '';
$success = '';

// Handle login via GET parameters (from footer modal)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email']) && isset($_GET['password'])) {
    $email = $_GET['email'];
    $password = $_GET['password'];
    
    // Hardcoded admin credentials
    if ($email === 'admin@aora.com' && $password === 'admin123') {
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_email'] = $email;
        $_SESSION['admin_name'] = 'Admin User';
        header('Location: admin.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Hardcoded admin credentials
    if ($email === 'admin@aora.com' && $password === 'admin123') {
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_email'] = $email;
        $_SESSION['admin_name'] = 'Admin User';
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Invalid email or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aora Admin - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f5efe8 0%, #e8dfd5 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(184, 154, 120, 0.2); border-radius: 32px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); padding: 2.5rem; }
        .login-btn { width: 100%; padding: 1rem; background: linear-gradient(145deg, #b89a78, #9b7e60); border: none; border-radius: 16px; color: white; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .login-btn:hover { background: linear-gradient(145deg, #a88b6d, #8a735b); transform: translateY(-2px); }
        .input-field { width: 100%; padding: 1rem 1.25rem 1rem 3rem; background: rgba(255, 255, 255, 0.9); border: 2px solid #e8dfd5; border-radius: 16px; transition: all 0.2s; }
        .input-field:focus { outline: none; border-color: #b89a78; background: white; box-shadow: 0 0 0 4px rgba(184, 154, 120, 0.1); }
    </style>
</head>
<body>
    <div class="auth-card" style="width: 100%; max-width: 480px; margin: 1.5rem;">
        <div class="text-center mb-8">
            <div style="width: 80px; height: 80px; background: linear-gradient(145deg, #b89a78, #8a735b); border-radius: 24px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                <span style="font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 700; color: white;">A</span>
            </div>
            <h1 style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 600; color: #3f352e;">Aora Admin</h1>
            <p style="color: #8a7a6a; font-size: 0.9rem; letter-spacing: 0.2em; text-transform: uppercase;">Luxury Resort & Restaurant</p>
        </div>
        
        <?php if ($error): ?>
        <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 12px; padding: 0.75rem 1rem; margin-bottom: 1rem; color: #991b1b; font-size: 0.85rem;">
            <i class="fas fa-exclamation-circle mr-2"></i><?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <form method="POST">
            <div style="margin-bottom: 1.5rem; position: relative;">
                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #4b3f35; margin-bottom: 0.5rem;">Email Address</label>
                <i class="fas fa-envelope" style="position: absolute; left: 1.25rem; top: 42px; color: #b89a78;"></i>
                <input type="email" name="email" class="input-field" placeholder="admin@aora.com" value="admin@aora.com" required>
            </div>
            
            <div style="margin-bottom: 1.5rem; position: relative;">
                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #4b3f35; margin-bottom: 0.5rem;">Password</label>
                <i class="fas fa-lock" style="position: absolute; left: 1.25rem; top: 42px; color: #b89a78;"></i>
                <input type="password" name="password" class="input-field" placeholder="••••••••" value="admin123" required>
            </div>
            
            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt mr-2"></i>Sign In to Dashboard
            </button>
        </form>
        
        <div style="margin-top: 1.5rem; padding: 0.75rem; background: rgba(184, 154, 120, 0.1); border-radius: 12px; border: 1px dashed rgba(184, 154, 120, 0.3); font-size: 0.8rem; color: #6b5d51; text-align: center;">
            <i class="fas fa-info-circle" style="color: #b89a78; margin-right: 0.25rem;"></i>
            Demo: admin@aora.com / admin123
        </div>
        
        <p class="text-center text-sm text-[#8a7a6a] mt-6">
            <i class="far fa-copyright mr-1"></i>2026 Aora Luxury Resort. All rights reserved.
        </p>
    </div>
</body>
</html>
