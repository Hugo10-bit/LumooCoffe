<?php
$currentPage = basename($_SERVER['PHP_SELF'] ?? '');
?>
<li>
    <a href="dashboard.php" class="<?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
        <i class="fas fa-chart-pie sidebar-fa-icon"></i>
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="profile.php" class="<?php echo ($currentPage == 'profile.php') ? 'active' : ''; ?>">
        <i class="fas fa-user-circle sidebar-fa-icon"></i>
        <span>Profile</span>
    </a>
</li>
<li>
    <a href="kategori_data.php" class="<?php echo (in_array($currentPage, ['kategori_data.php', 'kategori_tambah.php', 'kategori_edit.php'])) ? 'active' : ''; ?>">
        <i class="fas fa-tags sidebar-fa-icon"></i>
        <span>Categories</span>
    </a>
</li>
<li>
    <a href="produk_data.php" class="<?php echo (in_array($currentPage, ['produk_data.php', 'produk_tambah.php', 'produk_edit.php'])) ? 'active' : ''; ?>">
        <i class="fas fa-coffee sidebar-fa-icon"></i>
        <span>Products</span>
    </a>
</li>
<li>
    <a href="message.php" class="<?php echo ($currentPage == 'message.php') ? 'active' : ''; ?>">
        <i class="fas fa-envelope-open-text sidebar-fa-icon"></i>
        <span>Messages</span>
    </a>
</li>
<li style="margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.08);">
    <a href="../index.php" target="_blank" style="color: #d4a373;">
        <i class="fas fa-external-link-alt sidebar-fa-icon"></i>
        <span>Live Store</span>
    </a>
</li>
<li>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to logout?')" style="color: #ff9b9b;">
        <i class="fas fa-sign-out-alt sidebar-fa-icon"></i>
        <span>Logout</span>
    </a>
</li>
