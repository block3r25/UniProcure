<?php
/**
 * Complete Page Layout Template
 * Usage: <?php require_once __DIR__ . '/includes/layout.php'; ?>
 *
 * This template provides a complete page layout with:
 * - HTML head with common styles
 * - Sidebar navigation
 * - Header
 * - Content area for page-specific content
 *
 * Parameters (set before including):
 *   - $pageTitle: Page title (default: 'Dashboard')
 *   - $pageName: Page name for sidebar active state (default: 'dashboard')
 *   - $user: Current user array (required)
 *   - $showSearch: Show search in header (default: true)
 *   - $showNotifications: Show notifications (default: true)
 *   - $scripts: Additional JS files to include
 *   - $inlineScript: Inline JavaScript code
 */

$pageTitle = $pageTitle ?? 'Dashboard';
$pageName = $pageName ?? 'dashboard';
$showSearch = $showSearch ?? true;
$showNotifications = $showNotifications ?? true;
$scripts = $scripts ?? [];
$inlineScript = $inlineScript ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - University Procurement Portal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-page">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-small">
                <i class="fas fa-university"></i>
            </div>
            <span>UniProcure</span>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="nav-item <?php echo $pageName === 'dashboard' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <?php if (hasRole([ROLE_TWG, ROLE_ADMIN])): ?>
            <a href="manage_category.php" class="nav-item <?php echo $pageName === 'category' ? 'active' : ''; ?>">
                <i class="fas fa-layer-group"></i>
                <span>Manage Category</span>
            </a>
            <a href="#" class="nav-item <?php echo $pageName === 'upload' ? 'active' : ''; ?>" data-page="upload">
                <i class="fas fa-upload"></i>
                <span>Upload Specs</span>
            </a>
            <a href="#" class="nav-item <?php echo $pageName === 'manage' ? 'active' : ''; ?>" data-page="manage">
                <i class="fas fa-cog"></i>
                <span>Manage Items</span>
            </a>
            <?php endif; ?>
            <?php if (hasRole([ROLE_USER, ROLE_ADMIN])): ?>
            <a href="#" class="nav-item <?php echo $pageName === 'browse' ? 'active' : ''; ?>" data-page="browse">
                <i class="fas fa-search"></i>
                <span>Browse Items</span>
            </a>
            <a href="#" class="nav-item <?php echo $pageName === 'saved' ? 'active' : ''; ?>" data-page="saved">
                <i class="fas fa-bookmark"></i>
                <span>Saved Specs</span>
            </a>
            <?php endif; ?>
            <div class="nav-divider"></div>
            <a href="#" class="nav-item <?php echo $pageName === 'profile' ? 'active' : ''; ?>" data-page="profile">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
            <a href="#" class="nav-item <?php echo $pageName === 'settings' ? 'active' : ''; ?>" data-page="settings">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-details">
                    <span class="user-name"><?php echo htmlspecialchars($user['fullname']); ?></span>
                    <span class="user-role"><?php
                        if ($user['role'] === ROLE_ADMIN) {
                            echo 'Administrator';
                        } elseif ($user['role'] === ROLE_TWG) {
                            echo 'Technical Working Group';
                        } else {
                            echo 'End User';
                        }
                    ?></span>
                </div>
            </div>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="top-header">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="header-title">
                <h1 id="pageTitle"><?php echo htmlspecialchars($pageTitle); ?></h1>
            </div>
            <div class="header-actions">
                <?php if ($showSearch): ?>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search items...">
                </div>
                <?php endif; ?>
                <?php if ($showNotifications): ?>
                <button class="btn-icon" id="notificationsBtn">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <?php endif; ?>
            </div>
        </header>

        <!-- Page Content -->
        <div class="content-area">
            <?php include $contentTemplate ?? null; ?>
        </div>
    </main>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Action completed successfully</span>
    </div>

    <script src="js/app.js"></script>
    <script src="js/dashboard.js"></script>
    <?php foreach ($scripts as $script): ?>
    <script src="<?php echo htmlspecialchars($script); ?>"></script>
    <?php endforeach; ?>
    <?php if ($inlineScript): ?>
    <script>
        <?php echo $inlineScript; ?>
    </script>
    <?php endif; ?>
</body>
</html>