<?php
include_once __DIR__ . '/../session_helper.php';
session_start();

// Kosongkan data sesi, hapus cookie sesi, lalu hancurkan sesinya
$_SESSION = [];
lumoo_clear_auth_cookie();
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Location: ../login.php?pesan=logout');
exit;
