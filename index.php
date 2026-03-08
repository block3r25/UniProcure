<?php
session_start();
// Redirect to dashboard if already logged in
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Procurement Portal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="landing-page">
    <!-- Navigation -->
    <nav class="landing-nav">
        <div class="nav-container">
            <div class="nav-logo">
                <i class="fas fa-university"></i>
                <span>UniProcure</span>
            </div>
            <ul class="nav-menu">
                <li><a href="#features" class="nav-link">Features</a></li>
                <li><a href="#how-it-works" class="nav-link">How It Works</a></li>
                <li><a href="#" class="nav-link">About</a></li>
                <li><a href="#" class="nav-link">Contact</a></li>
            </ul>
            <div class="nav-actions">
                <a href="login.php" class="btn btn-outline">Sign In</a>
                <a href="login.php" class="btn btn-primary">Get Started</a>
            </div>
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <span class="hero-badge">
                    <i class="fas fa-rocket"></i>
                    Streamline Your Procurement Process
                </span>
                <h1 class="hero-title">
                    University Procurement <br>
                    <span class="gradient-text">Made Simple</span>
                </h1>
                <p class="hero-description">
                    Centralized platform for Technical Working Groups to manage specifications
                    and for End Users to easily access and copy technical details for procurement.
                </p>
                <div class="hero-actions">
                    <a href="login.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-right"></i> Access Portal
                    </a>
                    <a href="#features" class="btn btn-outline btn-lg">
                        <i class="fas fa-play-circle"></i> Learn More
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Items Managed</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Departments</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Access</span>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-card hero-card-1">
                    <i class="fas fa-laptop"></i>
                    <span>Computing</span>
                </div>
                <div class="hero-card hero-card-2">
                    <i class="fas fa-network-wired"></i>
                    <span>Networking</span>
                </div>
                <div class="hero-card hero-card-3">
                    <i class="fas fa-print"></i>
                    <span>Equipment</span>
                </div>
                <div class="hero-card hero-card-4">
                    <i class="fas fa-flask"></i>
                    <span>Laboratory</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-header">
            <span class="section-tag">Features</span>
            <h2 class="section-title">Everything You Need</h2>
            <p class="section-description">
                Our platform provides comprehensive tools for efficient procurement management
            </p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-upload"></i>
                </div>
                <h3>Upload Specifications</h3>
                <p>TWG can easily upload and manage technical specifications for all procurement items.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Easy Search</h3>
                <p>Quickly find items with powerful search functionality across all categories.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-copy"></i>
                </div>
                <h3>One-Click Copy</h3>
                <p>End users can copy technical specifications directly to their procurement documents.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3>Organized Categories</h3>
                <p>Items are categorized for easy navigation and browsing.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Role-Based Access</h3>
                <p>Different interfaces for TWG and End Users with appropriate permissions.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Real-Time Updates</h3>
                <p>Always access the latest specifications and item information.</p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="section-header">
            <span class="section-tag">How It Works</span>
            <h2 class="section-title">Simple Process</h2>
            <p class="section-description">
                Get started in just a few easy steps
            </p>
        </div>
        <div class="steps-container">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3>Sign In</h3>
                    <p>Login with your university credentials to access the portal.</p>
                </div>
            </div>
            <div class="step-connector">
                <i class="fas fa-arrow-right"></i>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3>Browse or Upload</h3>
                    <p>TWG uploads specs while End Users browse available items.</p>
                </div>
            </div>
            <div class="step-connector">
                <i class="fas fa-arrow-right"></i>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3>Copy & Procure</h3>
                    <p>Copy specifications to your procurement request documents.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- User Roles Section -->
    <section class="user-roles">
        <div class="roles-container">
            <div class="role-card role-twg">
                <div class="role-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h3>Technical Working Group</h3>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> Upload new specifications</li>
                    <li><i class="fas fa-check"></i> Edit existing items</li>
                    <li><i class="fas fa-check"></i> Manage inventory</li>
                    <li><i class="fas fa-check"></i> Approve specifications</li>
                </ul>
                <a href="login.php" class="btn btn-primary btn-block">TWG Login</a>
            </div>
            <div class="role-card role-user">
                <div class="role-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h3>End Users</h3>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> Browse all items</li>
                    <li><i class="fas fa-check"></i> View specifications</li>
                    <li><i class="fas fa-check"></i> Copy to clipboard</li>
                    <li><i class="fas fa-check"></i> Save for later</li>
                </ul>
                <a href="login.php" class="btn btn-primary btn-block">User Login</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-content">
            <h2>Ready to Get Started?</h2>
            <p>Join the university procurement portal today and streamline your procurement process.</p>
            <a href="login.php" class="btn btn-primary btn-lg">
                <i class="fas fa-sign-in-alt"></i> Sign In Now
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="landing-footer">
        <div class="footer-container">
            <div class="footer-brand">
                <div class="footer-logo">
                    <i class="fas fa-university"></i>
                    <span>UniProcure</span>
                </div>
                <p>University Procurement Portal - Streamlining technical specifications management.</p>
            </div>
            <div class="footer-links">
                <div class="footer-links-group">
                    <h4>Quick Links</h4>
                    <a href="#features">Features</a>
                    <a href="#how-it-works">How It Works</a>
                    <a href="#">About</a>
                    <a href="#">Contact</a>
                </div>
                <div class="footer-links-group">
                    <h4>Support</h4>
                    <a href="#">Help Center</a>
                    <a href="#">Documentation</a>
                    <a href="#">FAQ</a>
                    <a href="#">Report Issue</a>
                </div>
                <div class="footer-links-group">
                    <h4>Contact</h4>
                    <p><i class="fas fa-envelope"></i> procurement@university.edu</p>
                    <p><i class="fas fa-phone"></i> +1 234 567 890</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 University Procurement Portal. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/app.js"></script>
    <script src="js/landing.js"></script>
</body>
</html>