<?php
include 'db.php';
session_start();

// Sudah login? Tidak perlu daftar lagi
if (!empty($_SESSION['status_login'])) {
    header('Location: login.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $telpon   = trim($_POST['telpon'] ?? '');
    $alamat   = trim($_POST['alamat'] ?? '');
    $username = trim($_POST['user'] ?? '');
    $password = $_POST['pass'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Cek apakah username sudah dipakai
        $cek = mysqli_prepare($conn, "SELECT admin_id FROM tb_admin WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($cek, 's', $username);
        mysqli_stmt_execute($cek);
        mysqli_stmt_store_result($cek);

        if (mysqli_stmt_num_rows($cek) > 0) {
            $error = 'Username is already taken. Please choose another one.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "INSERT INTO tb_admin (nama, username, password, telpon, email, alamat, admin_name, level) VALUES (?, ?, ?, ?, ?, ?, '', 'pelanggan')");
            mysqli_stmt_bind_param($stmt, 'ssssss', $nama, $username, $hash, $telpon, $email, $alamat);

            if (mysqli_stmt_execute($stmt)) {
                header('Location: login.php?pesan=registered');
                exit;
            }
            $error = 'Failed to save data. Please try again.';
        }
    }
}

function old($key) {
    return htmlspecialchars($_POST[$key] ?? '');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Lumoo Coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Nunito:wght@400;600;700;800;900&family=Permanent+Marker&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
</head>
<body>

  <div class="auth-layout">
    <div class="auth-left">
      <img src="img/login.png" alt="Lumoo Club" class="auth-poster">
    </div>

    <div class="auth-right">
      <div class="auth-form-box">
        <h2>Register</h2>

        <?php if ($error): ?>
          <div class="auth-alert auth-alert-error" role="alert"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
          <div class="auth-form-group">
            <input type="text" id="nama" name="nama" placeholder="Full Name" autocomplete="name" value="<?php echo old('nama'); ?>" required>
          </div>
          <div class="auth-form-group">
            <input type="email" id="email" name="email" placeholder="Email" autocomplete="email" value="<?php echo old('email'); ?>" required>
          </div>
          <div class="auth-form-group">
            <input type="tel" id="telpon" name="telpon" placeholder="Phone Number" autocomplete="tel" value="<?php echo old('telpon'); ?>" required>
          </div>
          <div class="auth-form-group">
            <input type="text" id="alamat" name="alamat" placeholder="Address" autocomplete="street-address" value="<?php echo old('alamat'); ?>" required>
          </div>
          <div class="auth-form-group">
            <input type="text" id="user" name="user" placeholder="Username" autocomplete="username" value="<?php echo old('user'); ?>" required>
          </div>
          <div class="auth-form-group">
            <input type="password" id="pass" name="pass" placeholder="Password" autocomplete="new-password" required>
          </div>

          <button type="submit" name="submit" class="auth-btn">Register</button>

          <div class="auth-footer-text">
            Already have an account? <a href="login.php">Click here to login.</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
