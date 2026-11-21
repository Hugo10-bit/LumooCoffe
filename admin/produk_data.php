<?php include 'session.php'; ?>
<?php
// Handle toggle best seller
if (isset($_GET['toggle_bs'])) {
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styleadmin.css">
    <title>Product Data | Admin</title>
    <style>
      .card-title { font-family: 'Anton', sans-serif; font-size: 26px; color: #251a0d; margin-bottom: 8px; }
      .top-actions { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:12px; }
      .top-actions a.add {
        background: #382814;
        color: #fff !important;
        padding: 10px 20px;
        text-decoration: none !important;
        border: 2px solid #251a0d;
        font-weight: 800;
        border-radius: 8px;
        font-family: 'Nunito', sans-serif;
        font-size: 15px;
        display: inline-block;
        transition: background 0.3s;
      }
      .top-actions a.add:hover { background: #251a0d; }
      .action-links a { text-decoration:none; margin-right:6px; display:inline-block; margin-bottom:4px; }
      .action-links a.edit { background:#f0e6db; padding:6px 10px; border:2px solid #e0d1bf; color:#251a0d; font-weight:700; border-radius:6px; }
      .action-links a.delete { background:#ffecec; padding:6px 10px; border:2px solid #f5c6c6; color:#c0392b; font-weight:700; border-radius:6px; }
      .action-links a.bs-on {
        background: #fff3cd;
        padding: 6px 10px;
        border: 2px solid #ffc107;
        color: #856404;
        font-weight: 700;
        border-radius: 6px;
        font-size: 13px;
      }
      .action-links a.bs-off {
        background: #f8f9fa;
        padding: 6px 10px;
        border: 2px solid #dee2e6;
        color: #6c757d;
        font-weight: 700;
        border-radius: 6px;
        font-size: 13px;
      }
      .badge-bs {
        display: inline-block;
        background: #ffc107;
        color: #856404;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 20px;
        letter-spacing: 0.5px;
      }
      .badge-normal {
        display: inline-block;
        background: #e9ecef;
        color: #6c757d;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
      }
      .admin-card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow-x: auto; }
      .info-bs { background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 10px 16px; margin-bottom: 16px; font-size: 14px; color: #856404; font-weight: 600; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Product Data</div>
        </div>
        <div class="sidebar">
            <div class="sidebar-title">LumooCoffee</div>
            <ul>
                <?php include 'sidebar.php'; ?>
            </ul>
        </div>

        <div class="section">
            <div class="top-actions">
                <div>
                    <h2 class="card-title">Product Data</h2>
                    <p class="muted">Manage products in your store</p>
                </div>
                <div><a href="produk_tambah.php" class="add">Add Product</a></div>
            </div>

            <?php
            // Hitung jumlah best seller saat ini
            $count_bs = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_product WHERE is_bestseller = 1");
            $count_row = mysqli_fetch_assoc($count_bs);
            $jumlah_bs = $count_row['total'];
            ?>
            <div class="info-bs">
                ⭐ Active Best Sellers: <strong><?php echo $jumlah_bs; ?>/4</strong> products &nbsp;|&nbsp; Click the <strong>"⭐ Best Seller"</strong> button to change product best seller status
            </div>

            <div class="admin-card">
                <table class="table1" width="100%">
                    <tr>
                        <th style="width:5%;">No</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Best Seller</th>
                        <th style="width:18%;">Action</th>
                    </tr>

                    <?php
                    $no = 1;
                    $produk = mysqli_query($conn, "SELECT * FROM tb_product LEFT JOIN tb_category USING (category_id) ORDER BY product_id DESC");
                    if (mysqli_num_rows($produk) > 0) {
                        while ($row = mysqli_fetch_array($produk)) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['product_description']; ?></td>
                        <td>Rp. <?php echo number_format($row['product_price']); ?></td>
                        <td>
                            <a href="../produk/<?php echo $row['product_image']; ?>" target="_blank">
                                <img src="../produk/<?php echo $row['product_image']; ?>" width="50px" style="border-radius:6px;">
                            </a>
                        </td>
                        <td><?php echo ($row['product_status'] == 0) ? 'Inactive' : 'Active'; ?></td>
                        <td>
                            <?php if($row['is_bestseller'] == 1): ?>
                                <span class="badge-bs">⭐ Best Seller</span>
                            <?php else: ?>
                                <span class="badge-normal">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="action-links">
                            <!-- toggle best seller -->
                            <?php if($row['is_bestseller'] == 1): ?>
                                <a class="bs-on" href="produk_data.php?toggle_bs=<?php echo $row['product_id']; ?>" 
                                   onclick="return confirm('Remove from Best Seller?')">⭐ Best Seller</a>
                            <?php else: ?>
                                <a class="bs-off" href="produk_data.php?toggle_bs=<?php echo $row['product_id']; ?>"
                                   onclick="return confirm('Make this product a Best Seller?')">☆ Best Seller</a>
                            <?php endif; ?>
                            <a class="edit" href="produk_edit.php?id=<?php echo $row['product_id']; ?>">Edit</a>
                            <a class="delete" href="hapus_proses.php?idp=<?php echo $row['product_id']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                        </td>
                    </tr>
                    <?php } } else { ?>
                    <tr>
                        <td colspan="9">No data available</td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>