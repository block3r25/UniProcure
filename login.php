<?php
session_start();

// Demo users (in production, use a proper database)
$users = [
    'twg' => ['password' => 'twg123', 'role' => 'twg', 'name' => 'Technical Working Group'],
    'user' => ['password' => 'user123', 'role' => 'user', 'name' => 'End User']
];

// Redirect to dashboard if already logged in
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

// Handle login
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['user'] = [
            'username' => $username,
            'role' => $users[$username]['role'],
            'name' => $users[$username]['name']
        ];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - University Procurement Portal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <!-- Left Side - Branding -->
        <div class="auth-brand">
            <div class="brand-content">
                <div class="brand-logo">
                    <i class="fas fa-university"></i>
                </div>
                <h1>UniProcure</h1>
                <p class="brand-tagline">University Procurement Portal</p>
                <p class="brand-description">
                    Streamline your procurement process with our centralized platform for managing technical specifications.
                </p>
                <div class="brand-features">
                    <div class="brand-feature">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure Access</span>
                    </div>
                    <div class="brand-feature">
                        <i class="fas fa-bolt"></i>
                        <span>Fast & Easy</span>
                    </div>
                    <div class="brand-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Reliable</span>
                    </div>
                </div>
            </div>
            <div class="brand-footer">
                <a href="index.php" class="btn-link">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="auth-form-container">
            <div class="auth-form-wrapper">
                <div class="auth-header">
                    <h2>Welcome Back</h2>
                    <p>Sign in to access your account</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" id="passwordToggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>

                <div class="divider">
                    <span>or continue with</span>
                </div>

                <div class="social-login">
                    <button class="btn btn-social">
                        <i class="fab fa-google"></i>
                        <span>Google</span>
                    </button>
                    <button class="btn btn-social">
                        <i class="fab fa-microsoft"></i>
                        <span>Microsoft</span>
                    </button>
                </div>

                <div class="demo-credentials">
                    <p><strong>Demo Credentials:</strong></p>
                    <div class="demo-accounts">
                        <div class="demo-account">
                            <span class="demo-role">TWG</span>
                            <code>twg</code> / <code>twg123</code>
                        </div>
                        <div class="demo-account">
                            <span class="demo-role">End User</span>
                            <code>user</code> / <code>user123</code>
                        </div>
                    </div>
                </div>

                <p class="auth-footer">
                    Don't have an account? <a href="#">Contact Administrator</a>
                </p>
            </div>
        </div>
    </div>

    <script src="js/app.js"></script>
    <script src="js/auth.js"></script>
</body>
</html>