<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/auth.php';

requireLogin();
$user = getCurrentUser();

$activePage = 'settings';
$pageTitle = 'Settings';
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo htmlspecialchars($_COOKIE['theme'] ?? 'light'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - University Procurement Portal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/manage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .settings-group { display: flex; flex-direction: column; gap: 1rem; }
        .setting-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            background: var(--background);
        }
        .setting-label { display: flex; flex-direction: column; gap: 0.25rem; }
        .setting-label span { font-weight: 500; color: var(--text-primary); }
        .setting-label small { color: var(--text-secondary); font-size: 0.8rem; }
        .toggle-switch { position: relative; width: 48px; height: 26px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute;
            inset: 0;
            background: var(--border-color);
            border-radius: 26px;
            cursor: pointer;
            transition: 0.3s;
        }
        .toggle-slider:before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            left: 3px;
            top: 3px;
            background: white;
            border-radius: 50%;
            transition: 0.3s;
        }
        .toggle-switch input:checked + .toggle-slider { background: var(--primary-light); }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(22px); }
        .theme-options { display: flex; gap: 0.75rem; }
        .theme-option {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            cursor: pointer;
            text-align: center;
            transition: 0.2s;
            background: var(--surface);
            color: var(--text-primary);
        }
        .theme-option.active { border-color: var(--primary-light); color: var(--primary-light); }
        .theme-option i { display: block; font-size: 1.5rem; margin-bottom: 0.25rem; }
    </style>
</head>
<body class="dashboard-page">
    <?php require_once __DIR__ . '/includes/sidebar.php'; ?>
    <main class="main-content">
        <?php require_once __DIR__ . '/includes/header.php'; ?>
        <div class="content-area">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-header-icon"><i class="fas fa-cog"></i></div>
                    <div class="page-header-text">
                        <h2>Settings</h2>
                        <p>Manage your preferences</p>
                    </div>
                </div>
            </div>

            <div style="max-width: 600px;">
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-palette"></i> Appearance</h2>
                    </div>
                    <div class="card-body">
                        <div class="settings-group">

                            <!-- Theme -->
                            <div class="setting-item">
                                <div class="setting-label">
                                    <span>Theme</span>
                                    <small>Choose between light and dark mode</small>
                                </div>
                                <div class="theme-options">
                                    <div class="theme-option" id="themeLight">
                                        <i class="fas fa-sun"></i> Light
                                    </div>
                                    <div class="theme-option" id="themeDark">
                                        <i class="fas fa-moon"></i> Dark
                                    </div>
                                </div>
                            </div>

                            <!-- Compact Sidebar -->
                            <div class="setting-item">
                                <div class="setting-label">
                                    <span>Compact Sidebar</span>
                                    <small>Show icons only in the sidebar</small>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="compactSidebar">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <!-- Font Size -->
                            <div class="setting-item">
                                <div class="setting-label">
                                    <span>Font Size</span>
                                    <small>Adjust the base font size</small>
                                </div>
                                <select id="fontSize" style="padding: 0.4rem 0.75rem; border: 1px solid var(--border-color); border-radius: var(--radius-md); background: var(--surface); color: var(--text-primary);">
                                    <option value="14">Small</option>
                                    <option value="16" selected>Medium</option>
                                    <option value="18">Large</option>
                                </select>
                            </div>

                        </div>

                        <button class="btn btn-primary" id="saveBtn" style="width: 100%; margin-top: 1.5rem;">
                            <i class="fas fa-save"></i> Save Settings
                        </button>

                        <div id="saveMsg" style="display:none; text-align:center; margin-top:0.75rem; color: var(--success-color);">
                            <i class="fas fa-check-circle"></i> Settings saved successfully.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
    const html = document.documentElement;

    function getCookie(name) {
        return document.cookie.split('; ').find(r => r.startsWith(name + '='))?.split('=')[1] || null;
    }

    function setCookie(name, value, days = 365) {
        document.cookie = name + '=' + value + ';path=/;max-age=' + (days * 86400);
    }

    // Load saved settings
    const savedTheme = getCookie('theme') || 'light';
    const savedCompact = getCookie('compactSidebar') === 'true';
    const savedFont = getCookie('fontSize') || '16';

    html.setAttribute('data-theme', savedTheme);
    document.getElementById('compactSidebar').checked = savedCompact;
    document.getElementById('fontSize').value = savedFont;
    document.documentElement.style.fontSize = savedFont + 'px';

    // Highlight active theme
    function updateThemeButtons(theme) {
        document.getElementById('themeLight').classList.toggle('active', theme === 'light');
        document.getElementById('themeDark').classList.toggle('active', theme === 'dark');
    }
    updateThemeButtons(savedTheme);

    // Theme toggle
    document.getElementById('themeLight').addEventListener('click', () => {
        html.setAttribute('data-theme', 'light');
        updateThemeButtons('light');
    });
    document.getElementById('themeDark').addEventListener('click', () => {
        html.setAttribute('data-theme', 'dark');
        updateThemeButtons('dark');
    });

    // Font size preview
    document.getElementById('fontSize').addEventListener('change', function() {
        document.documentElement.style.fontSize = this.value + 'px';
    });

    // Compact sidebar preview
    document.getElementById('compactSidebar').addEventListener('change', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('compact', this.checked);
        document.querySelector('.main-content').style.marginLeft = this.checked ? '70px' : '';
    });

    // Save
    document.getElementById('saveBtn').addEventListener('click', () => {
        const theme = html.getAttribute('data-theme');
        const compact = document.getElementById('compactSidebar').checked;
        const font = document.getElementById('fontSize').value;

        setCookie('theme', theme);
        setCookie('compactSidebar', compact);
        setCookie('fontSize', font);

        const msg = document.getElementById('saveMsg');
        msg.style.display = 'block';
        setTimeout(() => msg.style.display = 'none', 3000);
    });
    </script>
</body>
</html>
