<?php include ('session.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width-device-width, initial-scale=1, shrink-to-fit-no">
    <title>LumooCoffee | Edit Category</title>
    <link rel="stylesheet" type="text/css" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> LumooCoffee | Edit Category</div>
        </div>

        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffee</b></div>
            <ul>
                <?php include'sidebar.php' ?>
            </ul>
        </div>

        <div class="section">
            <div class="container">
                <?php
                    $id_kategori = (int) ($_GET['id'] ?? 0);
                    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_category WHERE category_id = ?");
                    mysqli_stmt_bind_param($stmt, 'i', $id_kategori);
                    mysqli_stmt_execute($stmt);
                    $k = mysqli_fetch_object(mysqli_stmt_get_result($stmt));
                    if(!$k){
                        echo '<script>window.location="kategori_data.php"</script>';
                        exit;
                    }
                ?>
                <form action="" method="POST">
                    <h3>Edit Category Data</h3>
                    <fieldset>
                        <label>Category Name</label>
                        <input type="text" name="nama" value="<?php echo htmlspecialchars($k->category_name) ?>" class="form-control" required>
                    </fieldset>
                    <fieldset>
                        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Edit</button>
                    </fieldset>
                </form>
                <?php
                    if(isset($_POST['submit'])){
                        $nama = ucwords(trim($_POST['nama']));

                        $up = mysqli_prepare($conn, "UPDATE tb_category SET category_name = ? WHERE category_id = ?");
                        mysqli_stmt_bind_param($up, 'si', $nama, $k->category_id);

                        if(mysqli_stmt_execute($up)){
                            echo '<script>alert("Data edited successfully")</script>';
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

