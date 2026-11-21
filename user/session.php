<?php
// 1. Hubungkan ke database
include_once __DIR__ . '/../db.php';

// 2. Mulai sesi untuk melacak siapa pengguna yang sedang login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Jangan simpan halaman di cache browser, supaya setelah logout tombol Back tidak menampilkan halaman lama
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

// 4. Belum login? Arahkan ke halaman login
if (empty($_SESSION['status_login']) || empty($_SESSION['id_login'])) {
    header('Location: ../login.php?pesan=login');
    exit;
}

// 5. Ambil data lengkap pengguna dari database
$session_id = (int) $_SESSION['id_login'];

$stmt = mysqli_prepare($conn, "SELECT * FROM tb_admin WHERE admin_id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $session_id);
mysqli_stmt_execute($stmt);
$user_row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

// 6. Akun sudah tidak ada: paksa login ulang
if (!$user_row) {
    $_SESSION = [];
    session_destroy();
    header('Location: ../login.php?pesan=login');
    exit;
}

// Jika nama kosong, fallback ke username
if (empty($user_row['nama'])) {
    $user_row['nama'] = $user_row['username'];
}

$_SESSION['nama'] = $user_row['nama'];
