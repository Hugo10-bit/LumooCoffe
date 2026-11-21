<?php include ('session.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Profile</title>
    <link rel="stylesheet" type="text/css" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div><i class="fas fa-bars" style="margin-right: 15px; cursor: pointer; color: #382814;"></i> Admin Profile</div>
        </div>
        <div class="sidebar">
            <div class="sidebar-title"><b>LumooCoffee</b></div>
            <ul>
                <?php include 'sidebar.php' ?>
            </ul>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <?php
                $d = (object) $user_row;
            ?>
            <form id="contact" action="" method="post">
                <h3>Profile</h3>
                <fieldset>
                    <input type="text" name="nama" placeholder="Full Name" class="form-control" value="<?php echo htmlspecialchars($d->admin_name ?? '') ?>" required>
                </fieldset>
                <fieldset>
                    <input type="text" name="user" placeholder="Username" class="form-control" value="<?php echo htmlspecialchars($d->username ?? '') ?>" required>
                </fieldset>
                <fieldset>
                    <input type="text" name="hp" placeholder="Phone Number" class="form-control" value="<?php echo htmlspecialchars($d->telpon ?? '') ?>" required>
                </fieldset>
                <fieldset>
                    <input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo htmlspecialchars($d->email ?? '') ?>" required>
                </fieldset>
                <fieldset>
                    <input type="text" name="alamat" placeholder="Address" class="form-control" value="<?php echo htmlspecialchars($d->alamat ?? '') ?>" required>
                </fieldset>
                <fieldset>
                    <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Update Profile</button>
                </fieldset>
            </form>
            <?php
                if(isset($_POST['submit'])){
                    $nama   = ucwords(trim($_POST['nama']));
                    $user   = trim($_POST['user']);
                    $hp     = trim($_POST['hp']);
                    $email  = trim($_POST['email']);
                    $alamat = ucwords(trim($_POST['alamat']));

                    // Pastikan username baru belum dipakai akun lain
                    $cek = mysqli_prepare($conn, "SELECT admin_id FROM tb_admin WHERE username = ? AND admin_id <> ? LIMIT 1");
                    mysqli_stmt_bind_param($cek, 'si', $user, $d->admin_id);
                    mysqli_stmt_execute($cek);
                    mysqli_stmt_store_result($cek);

                    if (mysqli_stmt_num_rows($cek) > 0) {
                        echo '<script>alert("Username is already taken")</script>';
                    } else {
                        $up = mysqli_prepare($conn, "UPDATE tb_admin SET admin_name = ?, username = ?, telpon = ?, email = ?, alamat = ? WHERE admin_id = ?");
                        mysqli_stmt_bind_param($up, 'sssssi', $nama, $user, $hp, $email, $alamat, $d->admin_id);

                        if(mysqli_stmt_execute($up)){
                            echo '<script>alert("Data updated successfully")</script>';
                            echo '<script>window.location="profile.php"</script>';
                        }else{
                            echo 'failed '.htmlspecialchars(mysqli_error($conn));
                        }
                    }
                }
            ?>

            <form id="contact" action="" method="post">
                <h3>Change Password</h3>
                <fieldset>
                    <input type="password" name="pass1" placeholder="New Password" class="form-control" autocomplete="new-password" required>
                </fieldset>
                <fieldset>
                    <input type="password" name="pass2" placeholder="Confirm New Password" class="form-control" autocomplete="new-password" required>
                </fieldset>
                <fieldset>
                    <button name="ubah_password" type="submit" id="contact-submit" data-submit="...Sending">Change Password</button>
                </fieldset>
            </form>
            <?php
                if(isset($_POST['ubah_password'])){
                    $pass1 = $_POST['pass1'];
                    $pass2 = $_POST['pass2'];

                    if($pass2 !== $pass1){
                        echo '<script>alert("Confirm New Password does not match")</script>';
                    }else{
                        // Password disimpan dalam bentuk hash, bukan teks biasa
                        $hash = password_hash($pass1, PASSWORD_DEFAULT);
                        $up = mysqli_prepare($conn, "UPDATE tb_admin SET password = ? WHERE admin_id = ?");
                        mysqli_stmt_bind_param($up, 'si', $hash, $d->admin_id);

                        if(mysqli_stmt_execute($up)){
                            echo '<script>alert("Data updated successfully")</script>';
                            echo '<script>window.location="profile.php"</script>';
                        }else{
                            echo 'failed '.htmlspecialchars(mysqli_error($conn));
                        }
                    }
                }
            ?>
        </div>
    </div>
  <script src="../app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
