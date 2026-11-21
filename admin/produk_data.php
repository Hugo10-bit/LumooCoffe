<?php 
include 'session.php'; 

// Handle toggle best seller
if (isset($_GET['toggle_bs'])) {
    if (!$conn) {
        echo '<script>alert("Notice: Database belum terhubung ke cloud. Status Best Seller tidak dapat diubah di serverless demo mode."); window.location="produk_data.php";</script>';
        exit;
    }

    $id = (int)$_GET['toggle_bs'];
    $cek = mysqli_query($conn, "SELECT is_bestseller FROM tb_product WHERE product_id = '$id'");
    $row_bs = mysqli_fetch_assoc($cek);
    $new_val = ($row_bs['is_bestseller'] == 1) ? 0 : 1;

    // Jika mau set jadi bestseller, cek dulu sudah ada berapa
    if ($new_val == 1) {
        $count_bs = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_product WHERE is_bestseller = 1");
        $count_row = mysqli_fetch_assoc($count_bs);
        if ($count_row['total'] >= 4) {
            echo '<script>alert("Maximum of 4 Best Seller products! Uncheck other products first.")</script>';
            echo '<script>window.location="produk_data.php"</script>';
            exit;
        }
    }

    mysqli_query($conn, "UPDATE tb_product SET is_bestseller = '$new_val' WHERE product_id = '$id'");
    echo '<script>window.location="produk_data.php"</script>';
    exit;
}

$jumlah_bs = get_admin_bestseller_count($conn);
$produk = get_admin_products($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Products | Lumoo Admin</title>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Product Catalog</div>
            <div style="font-size: 14px; font-weight: 600; color: #8e6c4e;">
                <i class="fas fa-coffee"></i> Total: <strong><?php echo count($produk); ?></strong> Products
            </div>
        </div>
        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffee</b></div>
            <ul>
                <?php include 'sidebar.php'; ?>
            </ul>
        </div>

        <div class="section">
            <div class="top-actions">
                <div>
                    <h2 class="card-title">Product Catalog Management</h2>
                    <p class="muted">Add, edit prices, set bestsellers, and manage all cafe beverage & food items.</p>
                </div>
                <div style="display:flex; gap:10px; align-items:center;">
                    <?php if (!$conn): ?>
                    <span class="preview-badge"><i class="fas fa-database"></i> Demo Mode</span>
                    <?php endif; ?>
                    <a href="produk_tambah.php" class="add"><i class="fas fa-plus-circle"></i> Add New Product</a>
                </div>
            </div>

            <div class="info-bs">
                <i class="fas fa-star" style="color:#d97706; margin-right:6px;"></i>
                Active Best Sellers: <strong><?php echo $jumlah_bs; ?>/4</strong> slots filled &nbsp;|&nbsp; Click the <strong>"⭐ Best Seller"</strong> button to toggle spotlight on the homepage.
            </div>

            <div class="admin-card">
                <table class="table1" width="100%">
                    <thead>
                        <tr>
                            <th style="width:4%;">No</th>
                            <th style="width:9%;">Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Spotlight</th>
                            <th style="width:20%; text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (!empty($produk)) {
                            foreach ($produk as $row) {
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
                            <td><strong><?php echo $no++; ?></strong></td>
                            <td>
                                <div class="product-thumb-wrapper">
                                    <img src="../produk/<?php echo htmlspecialchars($row['product_image']); ?>" 
                                         alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                         class="product-thumb"
                                         onerror="this.onerror=null; this.src='../img/poster.jpeg';">
                                </div>
                            </td>
                            <td>
                                <strong style="color: #20160f; font-size: 15px;"><?php echo htmlspecialchars($row['product_name']); ?></strong>
                            </td>
                            <td>
                                <span class="cat-pill <?php echo $pillClass; ?>"><?php echo $catName; ?></span>
                            </td>
                            <td>
                                <span class="prod-desc-text" title="<?php echo htmlspecialchars($row['product_description']); ?>">
                                    <?php echo htmlspecialchars(mb_strimwidth($row['product_description'], 0, 48, '...')); ?>
                                </span>
                            </td>
                            <td>
                                <span class="price-text">Rp <?php echo number_format($row['product_price'], 0, ',', '.'); ?></span>
                            </td>
                            <td>
                                <?php if (($row['product_status'] ?? 1) == 1): ?>
                                    <span class="status-pill status-active"><i class="fas fa-check-circle"></i> Active</span>
                                <?php else: ?>
                                    <span class="status-pill status-inactive"><i class="fas fa-times-circle"></i> Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($row['is_bestseller'])): ?>
                                    <span class="badge-bs"><i class="fas fa-star"></i> Best Seller</span>
                                <?php else: ?>
                                    <span class="badge-normal">—</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <div class="action-links" style="justify-content: flex-end;">
                                    <?php if (!empty($row['is_bestseller'])): ?>
                                        <a class="bs-on" href="produk_data.php?toggle_bs=<?php echo $row['product_id']; ?>" 
                                           onclick="return confirm('Remove <?php echo addslashes($row['product_name']); ?> from Best Seller spotlight?')"><i class="fas fa-star"></i> Active</a>
                                    <?php else: ?>
                                        <a class="bs-off" href="produk_data.php?toggle_bs=<?php echo $row['product_id']; ?>"
                                           onclick="return confirm('Highlight <?php echo addslashes($row['product_name']); ?> as Best Seller?')"><i class="far fa-star"></i> Set BS</a>
                                    <?php endif; ?>
                                    <a class="edit" href="produk_edit.php?id=<?php echo $row['product_id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                                    <a class="delete" href="hapus_proses.php?idp=<?php echo $row['product_id']; ?>" onclick="return confirm('Are you sure you want to delete <?php echo addslashes($row['product_name']); ?>?')"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else { 
                        ?>
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 40px; color: #7f8c8d;">
                                <i class="fas fa-coffee" style="font-size: 36px; color: #d0c1b4; display: block; margin-bottom: 10px;"></i>
                                No products found in the catalog.
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
