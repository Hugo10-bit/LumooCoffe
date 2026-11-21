<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleadmin.css">
    <title>Add Category | Lumoo Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Add New Category</div>
        </div>

        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffee</b></div>
            <ul>
                <?php include 'sidebar.php'; ?>
            </ul>
        </div>

        <div class="section">
            <div class="container">
                <form action="" method="POST">
                    <h3 style="margin-top:0; color:#382814; font-size:24px;"><i class="fas fa-plus-circle"></i> Add Category</h3>
                    <p style="color:#7f8c8d; font-size:14px; margin-bottom:24px;">Create a new classification for coffee drinks or food items.</p>
                    
                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Category Name</label>
                        <input type="text" name="nama" 
                        placeholder="e.g. Signature Coffee, Artisan Bakery"
                        class="form-control" required>
                    </fieldset>
                    <fieldset style="display:flex; gap:12px; margin-top:20px;">
                        <button name="submit" type="submit"
                        id="contact-submit" data-submit="...Sending"><i class="fas fa-save"></i> Save Category</button>
                        <a href="kategori_data.php" style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; background:#f1ede8; color:#5c3a22; font-weight:700; padding:12px 24px; border-radius:10px; font-size:14px;">Cancel</a>
                    </fieldset>
                </form>
                <?php
                    if(isset($_POST['submit'])){
                        $nama = ucwords(trim($_POST['nama']));

                        if (!$conn) {
                            echo '<script>alert("Notice: Database cloud belum terhubung. Mode pratinjau aktif."); window.location="kategori_data.php";</script>';
                            exit;
                        }

                        $stmt = mysqli_prepare($conn, "INSERT INTO tb_category (category_name) VALUES (?)");
                        mysqli_stmt_bind_param($stmt, 's', $nama);

                        if(mysqli_stmt_execute($stmt)){
                            echo '<script>alert("Data added successfully")</script>';
                            echo '<script>window.location="kategori_data.php"</script>';
                        }else{
                            echo 'failed '.htmlspecialchars(mysqli_error($conn));
                        }
                    }
                    ?>
            </div>
        </div>
    </div>
  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
