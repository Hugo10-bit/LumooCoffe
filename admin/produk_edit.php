<?php 
include('session.php'); 

$id_produk = (int) ($_GET['id'] ?? 0);
$p = null;

if ($conn) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_product WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id_produk);
    mysqli_stmt_execute($stmt);
    $p = mysqli_fetch_object(mysqli_stmt_get_result($stmt));
} else {
    foreach ($DEFAULT_PRODUCTS as $prod) {
        if ($prod['product_id'] == $id_produk) {
            $p = (object) $prod;
            break;
        }
    }
}

if (!$p) {
    header('Location: produk_data.php');
    exit;
}

$kategori_list = get_app_categories($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Product | Lumoo Admin</title>
    <link rel="stylesheet" type="text/css" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Edit Product</div>
        </div>
        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffee</b></div>
            <ul>
                <?php include 'sidebar.php'; ?>
            </ul>
        </div>
        <div class="section">
            <div class="container">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3 style="margin-top:0; color:#382814; font-size:24px;"><i class="fas fa-edit"></i> Edit Product Data</h3>
                    <p style="color:#7f8c8d; font-size:14px; margin-bottom:24px;">Update product information, pricing, or product photo.</p>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Category</label>
                        <select class="form-control" name="kategori" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($kategori_list as $r): ?>
                            <option value="<?php echo $r['category_id']; ?>" <?php echo ($r['category_id'] == $p->category_id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($r['category_name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </fieldset>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Product Name</label>
                        <input type="text" name="nama" value="<?php echo htmlspecialchars($p->product_name); ?>" class="form-control" required>
                    </fieldset>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Price (Rp)</label>
                        <input type="text" name="harga" value="<?php echo htmlspecialchars($p->product_price); ?>" class="form-control" required>
                    </fieldset>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Current Image</label>
                        <div style="display:flex; align-items:center; gap:16px; margin-bottom:10px;">
                            <img src="../produk/<?php echo htmlspecialchars($p->product_image); ?>" 
                                 width="80px" height="80px" style="object-fit:cover; border-radius:10px; border:1px solid #ddd;"
                                 onerror="this.onerror=null; this.src='../img/poster.jpeg';">
                            <span style="font-size:13px; color:#7f8c8d;">Leave file input blank if you don't want to change the image.</span>
                        </div>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </fieldset>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Product Description</label>
                        <textarea class="form-control" name="deskripsi"><?php echo htmlspecialchars($p->product_description); ?></textarea>
                    </fieldset>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Status</label>
                        <select class="form-control" name="status">
                            <option value="1" <?php echo ($p->product_status == 1) ? 'selected' : ''; ?>>Active (Visible on Menu)</option>
                            <option value="0" <?php echo ($p->product_status == 0) ? 'selected' : ''; ?>>Inactive (Hidden)</option>
                        </select>
                    </fieldset>

                    <fieldset style="display:flex; gap:12px; margin-top:20px;">
                        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending"><i class="fas fa-check"></i> Save Changes</button>
                        <a href="produk_data.php" style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; background:#f1ede8; color:#5c3a22; font-weight:700; padding:12px 24px; border-radius:10px; font-size:14px;">Cancel</a>
                    </fieldset>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    if (!$conn) {
                        echo '<script>alert("Notice: Database cloud belum terhubung. Mode pratinjau aktif."); window.location="produk_data.php"</script>';
                        exit;
                    }

                    // 1. Ambil data dari form
                    $kategori  = (int) $_POST['kategori'];
                    $nama      = trim($_POST['nama']);
                    $harga     = (int) preg_replace('/\D/', '', $_POST['harga']);
                    $deskripsi = trim($_POST['deskripsi']);
                    $status    = ((int) $_POST['status']) === 1 ? 1 : 0;
                    $namagambar = $p->product_image; // default: pakai foto lama
                    $upload_ok  = true;

                    // 2. Jika admin meng-upload gambar baru
                    if (!empty($_FILES['gambar']['name'])) {
                        $tmp_name = $_FILES['gambar']['tmp_name'];
                        $ext      = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                        $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif', 'webp');

                        if (!in_array($ext, $tipe_diizinkan) || !is_uploaded_file($tmp_name) || @getimagesize($tmp_name) === false) {
                            echo '<script>alert("File format not allowed")</script>';
                            $upload_ok = false;
                        } else {
                            $newname = 'produk_' . time() . '.' . $ext;
                            if (move_uploaded_file($tmp_name, '../produk/' . $newname)) {
                                $old = __DIR__ . '/../produk/' . basename($p->product_image);
                                if ($p->product_image !== '' && is_file($old)) {
                                    @unlink($old);
                                }
                                $namagambar = $newname;
                            }
                        }
                    }

                    // 3. Update data produk
                    if ($upload_ok) {
                        $stmt = mysqli_prepare($conn, "UPDATE tb_product SET
                            category_id = ?, product_name = ?, product_price = ?,
                            product_description = ?, product_image = ?, product_status = ?
                            WHERE product_id = ?");
                        mysqli_stmt_bind_param($stmt, 'isissii', $kategori, $nama, $harga, $deskripsi, $namagambar, $status, $p->product_id);

                        if (mysqli_stmt_execute($stmt)) {
                            echo '<script>alert("Data updated successfully")</script>';
                            echo '<script>window.location="produk_data.php"</script>';
                        } else {
                            echo 'failed ' . htmlspecialchars(mysqli_error($conn));
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
