<?php 
include ('session.php');
$d = (object) $user_row;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Profile | Lumoo Admin</title>
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

        <div class="section">
            <div class="container">
                <div style="margin-bottom: 25px;">
                    <h2 class="card-title">Profile Settings</h2>
                    <p class="muted">Manage your administrator account credentials and contact info.</p>
                </div>

                <form id="contact" action="" method="post" style="margin-bottom: 30px;">
                    <h3 style="margin-top:0; color:#382814; font-size:20px;"><i class="fas fa-user-shield"></i> Account Information</h3>
                    
                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Full Name</label>
                        <input type="text" name="nama" placeholder="Full Name" class="form-control" value="<?php echo htmlspecialchars($d->admin_name ?? $d->nama ?? 'LumooCoffe'); ?>" required>
                    </fieldset>
                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Username</label>
                        <input type="text" name="user" placeholder="Username" class="form-control" value="<?php echo htmlspecialchars($d->username ?? 'LumooCoffe'); ?>" required>
                    </fieldset>
                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Phone Number</label>
                        <input type="text" name="hp" placeholder="Phone Number" class="form-control" value="<?php echo htmlspecialchars($d->telpon ?? '081234567890'); ?>" required>
                    </fieldset>
                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Email Address</label>
                        <input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo htmlspecialchars($d->email ?? 'lumoo_coffee@gmail.com'); ?>" required>
                    </fieldset>
                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Address</label>
                        <input type="text" name="alamat" placeholder="Address" class="form-control" value="<?php echo htmlspecialchars($d->alamat ?? 'Lumoo Coffee'); ?>" required>
                    </fieldset>
                    <fieldset style="margin-top: 20px;">
                        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending"><i class="fas fa-save"></i> Update Profile</button>
                    </fieldset>
                </form>
                <?php
                    if(isset($_POST['submit'])){
                        $nama   = ucwords(trim($_POST['nama']));
                        $user   = trim($_POST['user']);
                        $hp     = trim($_POST['hp']);
                        $email  = trim($_POST['email']);
                        $alamat = ucwords(trim($_POST['alamat']));

                        if (!$conn) {
                            $_SESSION['nama'] = $nama;
                            echo '<script>alert("Profile updated in current session! (Cloud database preview mode)"); window.location="profile.php";</script>';
                            exit;
                        }

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
                                $_SESSION['nama'] = $nama;
                                echo '<script>alert("Data updated successfully")</script>';
                                echo '<script>window.location="profile.php"</script>';
                            }else{
                                echo 'failed '.htmlspecialchars(mysqli_error($conn));
                            }
                        }
                    }
                ?>

                <form id="contact" action="" method="post">
                    <h3 style="margin-top:0; color:#382814; font-size:20px;"><i class="fas fa-key"></i> Change Password</h3>
                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">New Password</label>
                        <input type="password" name="pass1" placeholder="Enter new password" class="form-control" autocomplete="new-password" required>
                    </fieldset>
                    <fieldset>
                        <label style="font-weight:700; color:#382814; display:block; margin-bottom:8px;">Confirm New Password</label>
                        <input type="password" name="pass2" placeholder="Repeat new password" class="form-control" autocomplete="new-password" required>
                    </fieldset>
                    <fieldset style="margin-top: 20px;">
                        <button name="ubah_password" type="submit" id="contact-submit" data-submit="...Sending"><i class="fas fa-lock"></i> Change Password</button>
                    </fieldset>
                </form>
                <?php
                    if(isset($_POST['ubah_password'])){
                        $pass1 = $_POST['pass1'];
                        $pass2 = $_POST['pass2'];

                        if($pass2 !== $pass1){
                            echo '<script>alert("Confirm New Password does not match")</script>';
                        }else{
                            if (!$conn) {
                                echo '<script>alert("Password update simulated in preview mode!"); window.location="profile.php";</script>';
                                exit;
                            }

                            // Password disimpan dalam bentuk hash
                            $hash = password_hash($pass1, PASSWORD_DEFAULT);
                            $up = mysqli_prepare($conn, "UPDATE tb_admin SET password = ? WHERE admin_id = ?");
                            mysqli_stmt_bind_param($up, 'si', $hash, $d->admin_id);

                            if(mysqli_stmt_execute($up)){
                                echo '<script>alert("Password updated successfully")</script>';
                                echo '<script>window.location="profile.php"</script>';
                            }else{
                                echo 'failed '.htmlspecialchars(mysqli_error($conn));
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
