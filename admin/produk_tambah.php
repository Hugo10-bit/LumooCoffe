<?php 
include('session.php'); 
$kategori_list = get_app_categories($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Product | Lumoo Admin</title>
    <link rel="stylesheet" type="text/css" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Add New Product</div>
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
                    <h3 style="margin-top:0; color:#382814; font-size:24px;"><i class="fas fa-plus-circle"></i> Add New Product</h3>
                    <p style="color:#7f8c8d; font-size:14px; margin-bottom:24px;">Enter item details, price, category, and upload thumbnail image.</p>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Category</label>
                        <select class="form-control" name="kategori" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($kategori_list as $r): ?>
                            <option value="<?php echo $r['category_id']; ?>"><?php echo htmlspecialchars($r['category_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </fieldset>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Product Name</label>
                        <input type="text" name="nama" placeholder="e.g. Hazelnut Cream Latte" class="form-control" required>
                    </fieldset>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Price (Rp)</label>
                        <input type="text" name="harga" placeholder="e.g. 28000" class="form-control" required>
                    </fieldset>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Product Image</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </fieldset>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Product Description</label>
                        <textarea class="form-control" name="deskripsi" placeholder="Briefly describe taste, ingredients, or notes..."></textarea>
                    </fieldset>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Status</label>
                        <select class="form-control" name="status">
                            <option value="1">Active (Available on Menu)</option>
                            <option value="0">Inactive (Hidden)</option>
                        </select>
                    </fieldset>

                    <fieldset style="display:flex; gap:12px; margin-top:20px;">
                        <button name="submit" type="submit"><i class="fas fa-save"></i> Save Product</button>
                        <a href="produk_data.php" style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; background:#f1ede8; color:#5c3a22; font-weight:700; padding:12px 24px; border-radius:10px; font-size:14px;">Cancel</a>
                    </fieldset>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    if (!$conn) {
                        header('Location: produk_data.php?notif=demo_mode');
                        exit;
                    }

                    // 1. Ambil data dari form
                    $kategori  = (int) $_POST['kategori'];
                    $nama      = trim($_POST['nama']);
                    $harga     = (int) preg_replace('/\D/', '', $_POST['harga']);
                    $deskripsi = trim($_POST['deskripsi']);
                    $status    = ((int) $_POST['status']) === 1 ? 1 : 0;

                    // 2. Validasi file gambar (ekstensi + isi file benar-benar gambar)
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];
                    $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif', 'webp');

                    if (!in_array($ext, $tipe_diizinkan) || !is_uploaded_file($tmp_name) || @getimagesize($tmp_name) === false) {
                        echo '<script>alert("File format not allowed")</script>';
                    } else {
                        // 3. Simpan file dengan nama unik
                        $newname = 'produk_' . time() . '.' . $ext;
                        move_uploaded_file($tmp_name, '../produk/' . $newname);

                        // 4. Simpan data produk ke database
                        $stmt = mysqli_prepare($conn, "INSERT INTO tb_product
                            (category_id, product_name, product_price, product_description, product_image, product_status)
                            VALUES (?, ?, ?, ?, ?, ?)");
                        mysqli_stmt_bind_param($stmt, 'isissi', $kategori, $nama, $harga, $deskripsi, $newname, $status);

                        if (mysqli_stmt_execute($stmt)) {
                            header('Location: produk_data.php?notif=tambah_sukses');
                            exit;
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
