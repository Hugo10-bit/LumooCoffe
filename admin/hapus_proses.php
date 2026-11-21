<?php
// Wajib login sebagai admin sebelum bisa menghapus data
include 'session.php';

if (!$conn) {
    echo '<script>alert("Notice: Database cloud belum terhubung. Penghapusan data tidak dapat diproses dalam mode demo."); window.history.back();</script>';
    exit;
}

// 1. Hapus kategori
if (isset($_GET['idk'])) {
    $id = (int) $_GET['idk'];
    $stmt = mysqli_prepare($conn, "DELETE FROM tb_category WHERE category_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    header('Location: kategori_data.php');
    exit;
}

// 2. Hapus produk beserta file gambarnya
if (isset($_GET['idp'])) {
    $id = (int) $_GET['idp'];

    $stmt = mysqli_prepare($conn, "SELECT product_image FROM tb_product WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $p = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if ($p && $p['product_image'] !== '') {
        $file = __DIR__ . '/../produk/' . basename($p['product_image']);
        if (is_file($file)) {
            @unlink($file);
        }
    }

    $del = mysqli_prepare($conn, "DELETE FROM tb_product WHERE product_id = ?");
    mysqli_stmt_bind_param($del, 'i', $id);
    mysqli_stmt_execute($del);
    header('Location: produk_data.php');
    exit;
}

// 3. Hapus pesan pelanggan
if (isset($_GET['idc'])) {
    $id = (int) $_GET['idc'];
    $stmt = mysqli_prepare($conn, "DELETE FROM tb_message WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    header('Location: message.php');
    exit;
}

header('Location: dashboard.php');
exit;
