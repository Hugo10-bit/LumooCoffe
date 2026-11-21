<?php
include_once __DIR__ . '/../db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jangan simpan halaman admin di cache browser, supaya tombol Back setelah logout tidak menampilkan halaman lama
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

// Hanya user yang sudah login DAN ber-level admin yang boleh masuk
if (empty($_SESSION['status_login']) || empty($_SESSION['id_login']) || ($_SESSION['level'] ?? '') !== 'admin') {
    header('Location: ../login.php?pesan=login');
    exit;
}

$session_id = (int) $_SESSION['id_login'];

$stmt = mysqli_prepare($conn, "SELECT * FROM tb_admin WHERE admin_id = ? AND level = 'admin' LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $session_id);
mysqli_stmt_execute($stmt);
$user_row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

// Akun sudah dihapus / level berubah: paksa login ulang
if (!$user_row) {
    $_SESSION = [];
    session_destroy();
    header('Location: ../login.php?pesan=login');
    exit;
}
