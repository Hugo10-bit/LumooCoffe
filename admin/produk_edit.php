<?php include('session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Product | Admin</title>
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
                <?php include 'sidebar.php' ?>
            </ul>
        </div>
        <div class="section">
            <div class="container">
                <?php
                $id_produk = (int) ($_GET['id'] ?? 0);
                $stmt = mysqli_prepare($conn, "SELECT * FROM tb_product WHERE product_id = ?");
                mysqli_stmt_bind_param($stmt, 'i', $id_produk);
                mysqli_stmt_execute($stmt);
                $p = mysqli_fetch_object(mysqli_stmt_get_result($stmt));
                if (!$p) {
                    echo '<script>window.location="produk_data.php"</script>';
                    exit;
                }
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>Edit Product Data</h3>
                    <fieldset>
                        <label>Category Name</label>
                        <select class="form-control" name="kategori" required>
                            <option value="">--Select--</option>
                            <?php
                            $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY FIELD(category_name, 'Coffee', 'Non Coffee', 'Sweet', 'Light') ASC, category_id ASC");
                            while ($r = mysqli_fetch_array($kategori)) {
                            ?>
                            <option value="<?php echo $r['category_id'] ?>" <?php echo ($r['category_id'] == $p->category_id) ? 'selected' : ''; ?>><?php echo $r['category_name'] ?></option>
                            <?php } ?>
                        </select>
                    </fieldset>
                    <fieldset>
                        <label>Product Name</label>
                        <input type="text" name="nama" value="<?php echo htmlspecialchars($p->product_name) ?>" class="form-control" required>
                    </fieldset>
                    <fieldset>
                        <label>Price</label>
                        <input type="text" name="harga" value="<?php echo htmlspecialchars($p->product_price) ?>" class="form-control" required>
                    </fieldset>
                    <fieldset>
                        <label>Product Image</label>
                        <img src="../produk/<?php echo htmlspecialchars($p->product_image) ?>" width="100px">
                        <input type="file" name="gambar" placeholder="...Product Image..." class="form-control">
                    </fieldset>
                    <fieldset>
                        <label>Product Description</label>
                        <textarea class="form-control" name="deskripsi" placeholder="Description"><?php echo htmlspecialchars($p->product_description) ?></textarea><br>
                    </fieldset>
                    <fieldset>
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="">--Select--</option>
                            <option value="1" <?php echo ($p->product_status == 1) ? 'selected' : ''; ?>>Active</option>
                            <option value="0" <?php echo ($p->product_status == 0) ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </fieldset>
                    <fieldset>
                        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Edit</button>
                    </fieldset>
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    // 1. Ambil data dari form
                    $kategori  = (int) $_POST['kategori'];
                    $nama      = trim($_POST['nama']);
                    $harga     = (int) preg_replace('/\D/', '', $_POST['harga']);
                    $deskripsi = trim($_POST['deskripsi']);
                    $status    = ((int) $_POST['status']) === 1 ? 1 : 0;
                    $namagambar = $p->product_image; // default: pakai foto lama (diambil dari database, bukan dari form)
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
                                    unlink($old);
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
