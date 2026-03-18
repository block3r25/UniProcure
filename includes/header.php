<?php
/**
 * Reusable Header Template
 * Usage: <?php require_once __DIR__ . '/includes/header.php'; ?>
 * Parameters (set before including):
 *   - $pageTitle: The page title (default: 'Dashboard')
 *   - $showSearch: Show search box (default: true)
 *   - $showNotifications: Show notifications button (default: true)
 */
$pageTitle = $pageTitle ?? 'Dashboard';
$showSearch = $showSearch ?? true;
$showNotifications = $showNotifications ?? true;
?>
<!-- Header -->
<header class="top-header">
    <script>
    (function() {
        function getCookie(n) { return document.cookie.split('; ').find(r=>r.startsWith(n+'='))?.split('=')[1]||null; }
        const theme = getCookie('theme') || 'light';
        const font = getCookie('fontSize') || '16';
        const compact = getCookie('compactSidebar') === 'true';
        document.documentElement.setAttribute('data-theme', theme);
        document.documentElement.style.fontSize = font + 'px';
        if (compact) document.addEventListener('DOMContentLoaded', function() {
            const s = document.getElementById('sidebar');
            if (s) s.classList.add('compact');
        });
    })();
    </script>
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>
    <div class="header-title">
        <h1 id="pageTitle"><?php echo htmlspecialchars($pageTitle); ?></h1>
    </div>
    <div class="header-actions">
        <button class="btn-icon" id="fullscreenBtn" title="Toggle Fullscreen">
            <i class="fas fa-expand" id="fullscreenIcon"></i>
        </button>
    </div>
</header>
<script>
document.getElementById('fullscreenBtn').addEventListener('click', function() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        document.exitFullscreen();
    }
});
document.addEventListener('fullscreenchange', function() {
    document.getElementById('fullscreenIcon').className = document.fullscreenElement ? 'fas fa-compress' : 'fas fa-expand';
});
</script>