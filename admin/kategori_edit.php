<?php 
include 'session.php';

$id_kategori = (int) ($_GET['id'] ?? 0);
$k = null;

if ($conn) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_category WHERE category_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id_kategori);
    mysqli_stmt_execute($stmt);
    $k = mysqli_fetch_object(mysqli_stmt_get_result($stmt));
} else {
    // Fallback search
    foreach ($DEFAULT_CATEGORIES as $cat) {
        if ($cat['category_id'] == $id_kategori) {
            $k = (object) $cat;
            break;
        }
    }
}

if (!$k) {
    header('Location: kategori_data.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Category | Lumoo Admin</title>
    <link rel="stylesheet" type="text/css" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Edit Category</div>
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
                    <h3 style="margin-top:0; color:#382814; font-size:24px;"><i class="fas fa-edit"></i> Edit Category</h3>
                    <p style="color:#7f8c8d; font-size:14px; margin-bottom:24px;">Update category display name.</p>

                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Category Name</label>
                        <input type="text" name="nama" value="<?php echo htmlspecialchars($k->category_name); ?>" class="form-control" required>
                    </fieldset>
                    <fieldset style="display:flex; gap:12px; margin-top:20px;">
                        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending"><i class="fas fa-check"></i> Save Changes</button>
                        <a href="kategori_data.php" style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; background:#f1ede8; color:#5c3a22; font-weight:700; padding:12px 24px; border-radius:10px; font-size:14px;">Cancel</a>
                    </fieldset>
                </form>
                <?php
                    if(isset($_POST['submit'])){
                        $nama = ucwords(trim($_POST['nama']));

                        if (!$conn) {
                            header('Location: kategori_data.php?notif=demo_mode');
                            exit;
                        }

                        $up = mysqli_prepare($conn, "UPDATE tb_category SET category_name = ? WHERE category_id = ?");
                        mysqli_stmt_bind_param($up, 'si', $nama, $k->category_id);

                        if(mysqli_stmt_execute($up)){
                            header('Location: kategori_data.php?notif=edit_sukses');
                            exit;
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
