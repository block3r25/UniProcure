<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Demo items data (in production, fetch from database)
$items = [
    [
        'id' => 1,
        'name' => 'HP Laptop ProBook 450',
        'category' => 'Computing',
        'specs' => "Processor: Intel Core i7-1260P\nRAM: 16GB DDR4\nStorage: 512GB SSD\nDisplay: 15.6\" FHD IPS\nGraphics: Intel Iris Xe\nOS: Windows 11 Pro\nWarranty: 3 Years",
        'uploaded_by' => 'TWG',
        'date' => '2024-03-05'
    ],
    [
        'id' => 2,
        'name' => 'Epson EcoTank L3250',
        'category' => 'Office Equipment',
        'specs' => "Type: All-in-One Ink Tank Printer\nPrint Speed: Up to 33 ppm (B/W)\nResolution: 5760 x 1440 dpi\nConnectivity: USB, Wi-Fi\nPaper Size: A4, A5, B5\nInk Capacity: 70ml per color",
        'uploaded_by' => 'TWG',
        'date' => '2024-03-06'
    ],
    [
        'id' => 3,
        'name' => 'Cisco Catalyst Switch 2960',
        'category' => 'Networking',
        'specs' => "Ports: 48 x Gigabit Ethernet\nUplink: 4 x SFP\nSwitching Capacity: 104 Gbps\nForwarding Rate: 77.4 Mpps\nPoE: PoE+ (740W)\nLayer: Layer 2",
        'uploaded_by' => 'TWG',
        'date' => '2024-03-07'
    ],
    [
        'id' => 4,
        'name' => 'Dell UltraSharp U2723QE',
        'category' => 'Computing',
        'specs' => "Display: 27\" 4K UHD IPS\nResolution: 3840 x 2160\nRefresh Rate: 60Hz\nColor Accuracy: 99% sRGB\nConnectivity: USB-C, HDMI, DP\nAdjustment: Tilt, Swivel, Pivot",
        'uploaded_by' => 'TWG',
        'date' => '2024-03-08'
    ],
    [
        'id' => 5,
        'name' => 'Logitech MeetUp',
        'category' => 'Audio Visual',
        'specs' => "Type: Video Conference Camera\nResolution: 4K Ultra HD\nField of View: 120°\nAudio: 3-Microphone Beamforming\nConnectivity: USB, Bluetooth\nRange: Up to 4m audio pickup",
        'uploaded_by' => 'TWG',
        'date' => '2024-03-09'
    ]
];

$categories = ['Computing', 'Office Equipment', 'Networking', 'Audio Visual', 'Laboratory Equipment', 'Furniture', 'Other'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - University Procurement Portal</title>
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
            <a href="#" class="nav-item active" data-page="dashboard">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <?php if ($_SESSION['user']['role'] === 'twg'): ?>
            <a href="#" class="nav-item" data-page="upload">
                <i class="fas fa-upload"></i>
                <span>Upload Specs</span>
            </a>
            <a href="#" class="nav-item" data-page="manage">
                <i class="fas fa-cog"></i>
                <span>Manage Items</span>
            </a>
            <?php endif; ?>
            <?php if ($_SESSION['user']['role'] === 'user'): ?>
            <a href="#" class="nav-item" data-page="browse">
                <i class="fas fa-search"></i>
                <span>Browse Items</span>
            </a>
            <a href="#" class="nav-item" data-page="saved">
                <i class="fas fa-bookmark"></i>
                <span>Saved Specs</span>
            </a>
            <?php endif; ?>
            <div class="nav-divider"></div>
            <a href="#" class="nav-item" data-page="profile">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
            <a href="#" class="nav-item" data-page="settings">
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
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
                    <span class="user-role"><?php echo $_SESSION['user']['role'] === 'twg' ? 'Technical Working Group' : 'End User'; ?></span>
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
                <nav class="breadcrumb">
                    <a href="index.php">Home</a>
                    <i class="fas fa-chevron-right"></i>
                    <span>Dashboard</span>
                </nav>
                <h1 id="pageTitle">Dashboard</h1>
            </div>
            <div class="header-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search items...">
                </div>
                <button class="btn-icon" id="notificationsBtn">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="content-area">
            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="welcome-content">
                    <h2>Welcome back, <?php echo htmlspecialchars(explode(' ', $_SESSION['user']['name'])[0]); ?>!</h2>
                    <p>
                        <?php if ($_SESSION['user']['role'] === 'twg'): ?>
                        Manage technical specifications and approve procurement requests.
                        <?php else: ?>
                        Browse and copy technical specifications for your procurement needs.
                        <?php endif; ?>
                    </p>
                </div>
                <?php if ($_SESSION['user']['role'] === 'twg'): ?>
                <button class="btn btn-primary" id="uploadBannerBtn">
                    <i class="fas fa-plus"></i> Upload New Specs
                </button>
                <?php endif; ?>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon stat-icon-blue">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo count($items); ?></h3>
                        <p>Total Items</p>
                    </div>
                </div>
                <?php if ($_SESSION['user']['role'] === 'twg'): ?>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>12</h3>
                        <p>Approved Specs</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-orange">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>5</h3>
                        <p>Pending Review</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-purple">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo count($categories); ?></h3>
                        <p>Categories</p>
                    </div>
                </div>
                <?php else: ?>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-purple">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-info">
                        <h3>8</h3>
                        <p>Viewed Items</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-teal">
                        <i class="fas fa-copy"></i>
                    </div>
                    <div class="stat-info">
                        <h3>3</h3>
                        <p>Copied Specs</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-pink">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <div class="stat-info">
                        <h3>2</h3>
                        <p>Saved Items</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Recent Activity -->
            <div class="dashboard-grid">
                <!-- Items Table -->
                <div class="card card-main">
                    <div class="card-header">
                        <h2><i class="fas fa-list"></i> Technical Specifications</h2>
                        <div class="card-actions">
                            <div class="filter-group">
                                <select id="categoryFilter" class="form-control-sm">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php if ($_SESSION['user']['role'] === 'twg'): ?>
                            <button class="btn btn-primary btn-sm" id="uploadBtn">
                                <i class="fas fa-plus"></i> Upload New
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Uploaded By</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                    <tr data-id="<?php echo $item['id']; ?>" data-category="<?php echo $item['category']; ?>">
                                        <td>#<?php echo $item['id']; ?></td>
                                        <td>
                                            <div class="item-name">
                                                <i class="fas fa-box-open"></i>
                                                <?php echo htmlspecialchars($item['name']); ?>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-neutral"><?php echo htmlspecialchars($item['category']); ?></span></td>
                                        <td><?php echo htmlspecialchars($item['uploaded_by']); ?></td>
                                        <td><?php echo htmlspecialchars($item['date']); ?></td>
                                        <td>
                                            <button class="btn-icon btn-view" data-id="<?php echo $item['id']; ?>" title="View Specs">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if ($_SESSION['user']['role'] === 'user'): ?>
                                            <button class="btn-icon btn-copy" data-id="<?php echo $item['id']; ?>" title="Copy Specs">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button class="btn-icon btn-save" data-id="<?php echo $item['id']; ?>" title="Save for Later">
                                                <i class="far fa-bookmark"></i>
                                            </button>
                                            <?php endif; ?>
                                            <?php if ($_SESSION['user']['role'] === 'twg'): ?>
                                            <button class="btn-icon btn-edit" data-id="<?php echo $item['id']; ?>" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-delete" data-id="<?php echo $item['id']; ?>" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Panel -->
                <div class="card card-side">
                    <div class="card-header">
                        <h2><i class="fas fa-history"></i> Recent Activity</h2>
                    </div>
                    <div class="card-body">
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon activity-blue">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <div class="activity-content">
                                    <p>New spec uploaded</p>
                                    <span class="activity-time">2 hours ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon activity-green">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-content">
                                    <p>Item #3 approved</p>
                                    <span class="activity-time">5 hours ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon activity-purple">
                                    <i class="fas fa-copy"></i>
                                </div>
                                <div class="activity-content">
                                    <p>Specs copied by IT Dept</p>
                                    <span class="activity-time">1 day ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon activity-orange">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="activity-content">
                                    <p>Item #2 updated</p>
                                    <span class="activity-time">2 days ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- View Specs Modal -->
    <div class="modal" id="viewModal">
        <div class="modal-backdrop"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Item Specifications</h3>
                <button class="modal-close" id="closeModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="specs-container">
                    <div class="specs-header">
                        <span class="specs-category" id="modalCategory"></span>
                        <span class="specs-date" id="modalDate"></span>
                    </div>
                    <div class="specs-content">
                        <pre id="modalSpecs"></pre>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="closeModalBtn">Close</button>
                <?php if ($_SESSION['user']['role'] === 'user'): ?>
                <button class="btn btn-primary" id="copySpecsBtn">
                    <i class="fas fa-copy"></i> Copy Specifications
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal" id="uploadModal">
        <div class="modal-backdrop"></div>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h3>Upload Technical Specifications</h3>
                <button class="modal-close" id="closeUploadModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" id="uploadForm">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="itemName">Item Name *</label>
                            <input type="text" id="itemName" name="itemName" required placeholder="Enter item name">
                        </div>
                        <div class="form-group">
                            <label for="itemCategory">Category *</label>
                            <select id="itemCategory" name="itemCategory" required>
                                <option value="">Select category</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemSpecs">Technical Specifications *</label>
                        <textarea id="itemSpecs" name="itemSpecs" rows="10" required placeholder="Enter detailed technical specifications..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="itemFile">Attach Document (Optional)</label>
                        <div class="file-upload">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Drag & drop file or click to browse</p>
                            <input type="file" id="itemFile" name="itemFile" accept=".pdf,.doc,.docx,.xls,.xlsx">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelUpload">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Specifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Action completed successfully</span>
    </div>

    <script src="js/app.js"></script>
    <script src="js/dashboard.js"></script>
    <script>
        const itemsData = <?php echo json_encode($items); ?>;
        const userRole = '<?php echo $_SESSION['user']['role']; ?>';
    </script>
</body>
</html>