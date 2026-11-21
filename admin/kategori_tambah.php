<?php include 'session.php'; ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleadmin.css">
    <title>Add Category | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Add Category</div>
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
                    <fieldset>
                        <input type="text" name="nama" 
                        placeholder="Category Name"
                        class="form-control" required>
                    </fieldset>
                    <fieldset>
                        <button name="submit" type="submit"
                        id="contact-submit" data-submit="...Sending">Add</button>
                    </fieldset>
                </form>
                <?php
                    if(isset($_POST['submit'])){
                        $nama = ucwords(trim($_POST['nama']));

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
