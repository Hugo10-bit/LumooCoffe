<?php include('session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Product | Admin</title>
    <link rel="stylesheet" type="text/css" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Add Product</div>
        </div>
        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffe</b></div>
            <ul>
                <?php include 'sidebar.php' ?>
            </ul>
        </div>
        <div class="section">
            <div class="container">

                <form action="" method="post" enctype="multipart/form-data">
                    <h3>Add Product Data</h3>

                    <fieldset>
                        <label>Category Name</label>
                        <select class="form-control" name="kategori" required>
                            <option value="">--Select--</option>
                            <?php
                            $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY FIELD(category_name, 'Coffee', 'Non Coffee', 'Sweet', 'Light') ASC, category_id ASC");
                            while ($r = mysqli_fetch_array($kategori)) {
                            ?>
                            <option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
                            <?php } ?>
                        </select>
                    </fieldset>

                    <fieldset>
                        <label>Product Name</label>
                        <input type="text" name="nama" class="form-control" required>
                    </fieldset>

                    <fieldset>
                        <label>Price</label>
                        <input type="text" name="harga" class="form-control" required>
                    </fieldset>

                    <fieldset>
                        <label>Product Image</label>
                        <input type="file" name="gambar" class="form-control" required>
                    </fieldset>

                    <fieldset>
                        <label>Product Description</label>
                        <textarea class="form-control" name="deskripsi"></textarea>
                    </fieldset>

                    <fieldset>
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </fieldset>

                    <fieldset>
                        <button name="submit" type="submit">Add</button>
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
                            echo '<script>alert("Data added successfully")</script>';
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
