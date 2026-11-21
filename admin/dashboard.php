<?php 
include 'session.php'; 

// Fetch statistics safely
$categories = get_admin_categories($conn);
$products = get_admin_products($conn);
$messages = get_admin_messages($conn);
$total_products = count($products);
$total_categories = count($categories);
$total_bestsellers = get_admin_bestseller_count($conn);
$total_messages = count($messages);

// Compute category counts
$cat_counts = [];
foreach ($products as $p) {
    $cname = $p['category_name'] ?? 'Other';
    $cat_counts[$cname] = ($cat_counts[$cname] ?? 0) + 1;
}

$admin_display_name = htmlspecialchars($user_row["admin_name"] ?? $user_row["nama"] ?? 'Lumoo Admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styleadmin.css">
    <title>Admin Dashboard | Lumoo Coffee</title>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div style="display:flex; align-items:center; gap:12px;">
                <i class="fas fa-bars" id="sidebarToggle" style="cursor: pointer; color: #382814; font-size: 20px;"></i> 
                <div>
                    <span style="color: #8e6c4e; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Lumoo Coffee Admin</span>
                    <h4 style="margin: 0; font-size: 18px; color: #20160f; font-weight: 800;">Dashboard Overview</h4>
                </div>
            </div>
            <div class="header-right">
                <span class="store-status-pill"><span class="pulse-dot"></span> Cafe Open (08:00 - 23:00)</span>
                <a href="../index.php" target="_blank" class="view-store-btn"><i class="fas fa-external-link-alt"></i> View Storefront</a>
                <div class="admin-chip">
                    <img src="../img/user-icon.png" alt="Admin" class="admin-avatar" onerror="this.src='../img/login.png'">
                    <span class="admin-name"><?php echo $admin_display_name; ?></span>
                </div>
            </div>
        </div>
        
        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffee</b></div>
            <ul>
                <?php include 'sidebar.php'; ?>
            </ul>
        </div>

        <div class="section">
            <!-- Modern Hero Banner -->
            <div class="dashboard-hero">
                <div class="hero-content">
                    <div class="hero-badge"><i class="fas fa-mug-hot"></i> Coffee Shop Control Center</div>
                    <h2>Welcome back, <?php echo $admin_display_name; ?>! ☕</h2>
                    <p>Manage your artisan coffee menus, update pricing, track customer messages, and curate homepage bestsellers from one place.</p>
                    <div class="hero-actions">
                        <a href="produk_tambah.php" class="hero-btn hero-btn-primary"><i class="fas fa-plus"></i> Add Product</a>
                        <a href="kategori_tambah.php" class="hero-btn hero-btn-secondary"><i class="fas fa-tag"></i> Add Category</a>
                        <a href="message.php" class="hero-btn hero-btn-outline"><i class="fas fa-envelope"></i> View Messages (<?php echo $total_messages; ?>)</a>
                        <a href="../ourmenu.php" target="_blank" class="hero-btn hero-btn-ghost"><i class="fas fa-book-open"></i> Live Menu</a>
                    </div>
                </div>
                <div class="hero-illustration">
                    <img src="../img/cup-icon.png" alt="Lumoo Coffee Cup" onerror="this.style.display='none'">
                </div>
            </div>

            <!-- Stat Metric Cards -->
            <div class="dashboard-cards">
                <!-- Card 1: Total Products -->
                <div class="card stat-card">
                    <div class="card-icon icon-coffee">
                        <i class="fas fa-coffee"></i>
                    </div>
                    <div class="card-info">
                        <span class="card-label">Total Products</span>
                        <h3><?php echo $total_products; ?></h3>
                        <div class="card-footer-info">
                            <span class="badge-success"><i class="fas fa-check-circle"></i> 100% Active</span>
                            <a href="produk_data.php" class="card-link">Manage →</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Categories -->
                <div class="card stat-card">
                    <div class="card-icon icon-tag">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="card-info">
                        <span class="card-label">Categories</span>
                        <h3><?php echo $total_categories; ?></h3>
                        <div class="card-footer-info">
                            <span class="badge-neutral">Coffee & Treats</span>
                            <a href="kategori_data.php" class="card-link">View All →</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Best Sellers -->
                <div class="card stat-card">
                    <div class="card-icon icon-star">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="card-info">
                        <span class="card-label">Best Sellers</span>
                        <h3><?php echo $total_bestsellers; ?> <span class="max-badge">/ 4</span></h3>
                        <div class="card-footer-info">
                            <span class="badge-gold"><i class="fas fa-award"></i> Featured</span>
                            <a href="produk_data.php" class="card-link">Adjust →</a>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Customer Messages -->
                <div class="card stat-card">
                    <div class="card-icon icon-message">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <div class="card-info">
                        <span class="card-label">Messages</span>
                        <h3><?php echo $total_messages; ?></h3>
                        <div class="card-footer-info">
                            <span class="badge-info">Inquiries</span>
                            <a href="message.php" class="card-link">Read →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two Column Main Grid -->
            <div class="dash-grid-2">
                <!-- Left Main: Recent Products Preview -->
                <div class="dash-main-col">
                    <div class="admin-card">
                        <div class="card-header-flex">
                            <div>
                                <h3 class="dash-box-title"><i class="fas fa-fire" style="color:#d97706;"></i> Featured Menu Products</h3>
                                <p class="muted" style="margin:4px 0 0;">Recent and popular selections displayed on customer menu</p>
                            </div>
                            <a href="produk_data.php" class="btn-sm-outline">View All (<?php echo $total_products; ?>) <i class="fas fa-arrow-right"></i></a>
                        </div>

                        <div class="table-responsive" style="margin-top: 15px;">
                            <table class="table1" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">Item</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th style="text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $sample_products = array_slice($products, 0, 5);
                                    foreach ($sample_products as $row): 
                                        $catName = htmlspecialchars($row['category_name'] ?? 'General');
                                        $pillClass = 'cat-pill-coffee';
                                        if (stripos($catName, 'Coffee') !== false && stripos($catName, 'Non') === false) {
                                            $pillClass = 'cat-pill-coffee';
                                        } elseif (stripos($catName, 'Non') !== false) {
                                            $pillClass = 'cat-pill-noncoffee';
                                        } elseif (stripos($catName, 'Sweet') !== false) {
                                            $pillClass = 'cat-pill-sweet';
                                        } elseif (stripos($catName, 'Light') !== false) {
                                            $pillClass = 'cat-pill-light';
                                        }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="product-thumb-wrapper" style="width: 44px; height: 44px;">
                                                <img src="../produk/<?php echo htmlspecialchars($row['product_image']); ?>" 
                                                     alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                                     class="product-thumb"
                                                     onerror="this.onerror=null; this.src='../img/poster.jpeg';">
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 800; color: #20160f; font-size: 14px;">
                                                <?php echo htmlspecialchars($row['product_name']); ?>
                                            </div>
                                            <span style="font-size: 12px; color: #7f8c8d;">
                                                <?php echo htmlspecialchars(mb_strimwidth($row['product_description'] ?? '', 0, 36, '...')); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="cat-pill <?php echo $pillClass; ?>"><?php echo $catName; ?></span>
                                        </td>
                                        <td>
                                            <strong style="color: #382814;">Rp <?php echo number_format($row['product_price'], 0, ',', '.'); ?></strong>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['is_bestseller'])): ?>
                                                <span class="badge-bs" style="font-size: 11px;"><i class="fas fa-star"></i> Best Seller</span>
                                            <?php else: ?>
                                                <span class="status-pill status-active" style="font-size: 11px;">Active</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="produk_edit.php?id=<?php echo $row['product_id']; ?>" class="action-btn-mini" title="Edit Product">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Category Breakdown Grid -->
                    <div class="admin-card" style="margin-top: 25px;">
                        <h3 class="dash-box-title"><i class="fas fa-layer-group" style="color: #8e6c4e;"></i> Menu Category Distribution</h3>
                        <p class="muted" style="margin: 4px 0 16px;">Live breakdown of beverage & food items by section</p>
                        <div class="category-grid">
                            <?php 
                            foreach ($categories as $cat): 
                                $cName = $cat['category_name'];
                                $cCount = $cat_counts[$cName] ?? 0;
                                $cIcon = 'fa-coffee';
                                $pillTheme = 'cat-pill-coffee';
                                if (stripos($cName, 'Coffee') !== false && stripos($cName, 'Non') === false) {
                                    $cIcon = 'fa-coffee';
                                    $pillTheme = 'cat-pill-coffee';
                                } elseif (stripos($cName, 'Non') !== false) {
                                    $cIcon = 'fa-leaf';
                                    $pillTheme = 'cat-pill-noncoffee';
                                } elseif (stripos($cName, 'Sweet') !== false) {
                                    $cIcon = 'fa-cookie-bite';
                                    $pillTheme = 'cat-pill-sweet';
                                } elseif (stripos($cName, 'Light') !== false) {
                                    $cIcon = 'fa-utensils';
                                    $pillTheme = 'cat-pill-light';
                                }
                            ?>
                            <div class="cat-dist-card">
                                <div class="cat-dist-icon <?php echo $pillTheme; ?>">
                                    <i class="fas <?php echo $cIcon; ?>"></i>
                                </div>
                                <div class="cat-dist-info">
                                    <h4><?php echo htmlspecialchars($cName); ?></h4>
                                    <span><?php echo $cCount; ?> Items Available</span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Side Col: Store Info & Recent Messages -->
                <div class="dash-side-col">
                    <!-- Store Operations Card -->
                    <div class="admin-card side-info-card">
                        <div class="store-badge-card">
                            <div class="store-badge-icon"><i class="fas fa-store-alt"></i></div>
                            <div>
                                <h4 style="margin:0; font-size:16px; color:#fff;">Lumoo Coffee Shop</h4>
                                <span style="font-size:12px; color:rgba(255,255,255,0.75);">Malang, East Java</span>
                            </div>
                        </div>

                        <ul class="store-info-list">
                            <li>
                                <div class="si-icon"><i class="far fa-clock"></i></div>
                                <div class="si-details">
                                    <span class="si-label">Operating Hours</span>
                                    <span class="si-val">Mon - Sun: 08:00 - 23:00</span>
                                </div>
                            </li>
                            <li>
                                <div class="si-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="si-details">
                                    <span class="si-label">Main Outlet</span>
                                    <span class="si-val">Jl. Lumoo Kopi No. 10</span>
                                </div>
                            </li>
                            <li>
                                <div class="si-icon"><i class="fas fa-shield-alt"></i></div>
                                <div class="si-details">
                                    <span class="si-label">Security & Session</span>
                                    <span class="si-val" style="color: #10b981; font-weight:700;"><i class="fas fa-lock"></i> HMAC-SHA256 Signed</span>
                                </div>
                            </li>
                            <li>
                                <div class="si-icon"><i class="fas fa-cloud"></i></div>
                                <div class="si-details">
                                    <span class="si-label">Hosting Engine</span>
                                    <span class="si-val">Vercel Serverless (sin1)</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Latest Messages Snippet -->
                    <div class="admin-card" style="margin-top: 25px;">
                        <div class="card-header-flex">
                            <h3 class="dash-box-title" style="font-size:17px;"><i class="fas fa-inbox" style="color:#8e6c4e;"></i> Recent Feedback</h3>
                            <a href="message.php" class="card-link" style="font-size:12px;">See all →</a>
                        </div>
                        <div class="mini-message-list">
                            <?php 
                            $recent_msgs = array_slice($messages, 0, 3);
                            if (!empty($recent_msgs)):
                                foreach ($recent_msgs as $msg):
                            ?>
                            <div class="mini-msg-item">
                                <div class="mini-msg-header">
                                    <strong style="color:#20160f; font-size:13px; display:flex; align-items:center; gap:6px;">
                                        <i class="fas fa-user-circle" style="color:#8e6c4e;"></i>
                                        <?php echo htmlspecialchars($msg['nama']); ?>
                                    </strong>
                                    <span style="font-size:11px; color:#95a5a6;"><?php echo !empty($msg['created_at']) ? date('d M', strtotime($msg['created_at'])) : 'Recent'; ?></span>
                                </div>
                                <p class="mini-msg-text">
                                    "<?php echo htmlspecialchars(mb_strimwidth($msg['pesan'], 0, 75, '...')); ?>"
                                </p>
                            </div>
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <p style="text-align:center; color:#95a5a6; padding:15px; font-size:13px;">No new messages.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quick Shortcuts -->
                    <div class="admin-card" style="margin-top: 25px;">
                        <h3 class="dash-box-title" style="font-size:17px;"><i class="fas fa-bolt" style="color:#d97706;"></i> Quick Shortcuts</h3>
                        <div class="quick-shortcuts-grid">
                            <a href="profile.php" class="shortcut-btn">
                                <i class="fas fa-user-cog"></i> Profile
                            </a>
                            <a href="kategori_data.php" class="shortcut-btn">
                                <i class="fas fa-tags"></i> Categories
                            </a>
                            <a href="produk_data.php" class="shortcut-btn">
                                <i class="fas fa-coffee"></i> Products
                            </a>
                            <a href="../contact.php" target="_blank" class="shortcut-btn">
                                <i class="fas fa-envelope"></i> Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
