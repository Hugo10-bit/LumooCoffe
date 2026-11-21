<?php
    // 1. Siapkan pengaturan dasar untuk menghubungkan PHP dengan database MySQL
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $isLocal = str_starts_with($host, 'localhost') || str_starts_with($host, '127.0.0.1');

    if ($isLocal) {
        $hostname = 'localhost';
        $username = 'root';
        $password = '';
        $dbname   = 'lumoo_coffe';
    } else {
        $hostname = 'sql105.infinityfree.com';
        $username = 'if0_42054865';
        $password = 'Hugoputra8910';
        $dbname   = 'if0_42054865_lumoo_coffe';
    }

    // 2. Lakukan koneksi (penghubungan) menggunakan pengaturan di atas
    $conn = mysqli_connect($hostname, $username, $password, $dbname);

    // 3. Cek kondisi: jika koneksi gagal, tampilkan pesan error
    if (mysqli_connect_errno()) {
        echo "Koneksi database gagal: " . mysqli_connect_error();
    }