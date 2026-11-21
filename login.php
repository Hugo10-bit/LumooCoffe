<?php
include 'db.php';
session_start();

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

function redirect_by_level($level) {
    if ($level === 'admin') {
        header('Location: admin/dashboard.php');
    } elseif ($level === 'pelanggan') {
        header('Location: user/dashboard_user.php');
    } else {
        header('Location: index.php');
    }
    exit;
}

// Sudah login? Langsung ke dashboard masing-masing
if (!empty($_SESSION['status_login'])) {
    redirect_by_level($_SESSION['level'] ?? '');
}

$error  = '';
$notice = '';
$pesan  = $_GET['pesan'] ?? '';
if ($pesan === 'logout')     $notice = 'You have been logged out. Please log in again.';
if ($pesan === 'login')      $notice = 'Please log in first to continue.';
if ($pesan === 'registered') $notice = 'Registration successful. Please log in.';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['user'] ?? '');
    $password = $_POST['pass'] ?? '';

    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_admin WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    $valid = false;
    if ($row) {
        $stored = $row['password'];
        $isHash = !empty(password_get_info($stored)['algo']);

        if ($isHash && password_verify($password, $stored)) {
            $valid = true;
        } elseif (!$isHash && hash_equals($stored, $password)) {
            // Password lama masih teks biasa: terima sekali, lalu langsung diubah jadi hash
            $valid = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $up = mysqli_prepare($conn, "UPDATE tb_admin SET password = ? WHERE admin_id = ?");
            mysqli_stmt_bind_param($up, 'si', $newHash, $row['admin_id']);
            mysqli_stmt_execute($up);
        }
    }

    if ($valid) {
        session_regenerate_id(true);
        $_SESSION['id_login']     = $row['admin_id'];
        $_SESSION['level']        = $row['level'];
        $_SESSION['status_login'] = true;
        $_SESSION['nama']         = $row['nama'];
        redirect_by_level($row['level']);
    }

    $error = 'Incorrect username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lumoo Coffee</title>
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
        <h2>Login</h2>

        <?php if ($error): ?>
          <div class="auth-alert auth-alert-error" role="alert"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif ($notice): ?>
          <div class="auth-alert" role="status"><?php echo htmlspecialchars($notice); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
          <div class="auth-form-group">
            <input type="text" id="user" name="user" placeholder="Username" autocomplete="username"
                   value="<?php echo htmlspecialchars($_POST['user'] ?? ''); ?>" required>
          </div>

          <div class="auth-form-group">
            <input type="password" id="pass" name="pass" placeholder="Password" autocomplete="current-password" required>
          </div>

          <button type="submit" name="submit" class="auth-btn">Login</button>

          <div class="auth-footer-text">
            Don't have an account? <a href="register.php">Click here to register.</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="app.js?v=<?php echo time(); ?>" defer></script>
</body>
</html>
