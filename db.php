<?php
    // Set temporary session save path for Serverless / Cloud environments if needed
    if (session_status() === PHP_SESSION_NONE) {
        $currSavePath = session_save_path();
        if (empty($currSavePath) || !is_dir($currSavePath) || !is_writable($currSavePath)) {
            $tmpSession = sys_get_temp_dir() . '/php_sessions';
            if (!is_dir($tmpSession)) {
                @mkdir($tmpSession, 0777, true);
            }
            if (is_dir($tmpSession) && is_writable($tmpSession)) {
                @session_save_path($tmpSession);
            }
        }
    }

    // Hindari fatal uncaught exception pada PHP 8.1+
    mysqli_report(MYSQLI_REPORT_OFF);

    // Konfigurasi koneksi database MySQL
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $isLocal = str_starts_with($host, 'localhost') || str_starts_with($host, '127.0.0.1');

    // 1. Prioritaskan Environment Variables jika ada (untuk Vercel/Railway/Cloud Hosting)
    $envHost = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? null);
    $envUser = getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? null);
    $envPass = getenv('DB_PASS') ?: ($_ENV['DB_PASS'] ?? (getenv('DB_PASSWORD') ?: ($_ENV['DB_PASSWORD'] ?? null)));
    $envName = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? (getenv('DB_DATABASE') ?: ($_ENV['DB_DATABASE'] ?? null)));
    $envPort = (int)(getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? 3306));

    $conn = false;
    $db_error = '';

    if ($envHost && $envUser && $envName) {
        $hostname = $envHost;
        $username = $envUser;
        $password = $envPass ?? '';
        $dbname   = $envName;
        $port     = $envPort;
    } elseif ($isLocal) {
        $hostname = 'localhost';
        $username = 'root';
        $password = '';
        $dbname   = 'lumoo_coffe';
        $port     = 3306;
    } else {
        $hostname = 'sql105.infinityfree.com';
        $username = 'if0_42054865';
        $password = 'Hugoputra8910';
        $dbname   = 'if0_42054865_lumoo_coffe';
        $port     = 3306;
    }

    try {
        $conn = @mysqli_connect($hostname, $username, $password, $dbname, $port);
        if (!$conn) {
            $db_error = mysqli_connect_error();
        }
    } catch (\Throwable $e) {
        $conn = false;
        $db_error = $e->getMessage();
    }

    require_once __DIR__ . '/data.php';
    require_once __DIR__ . '/session_helper.php';

    if (session_status() === PHP_SESSION_ACTIVE) {
        lumoo_restore_auth_session();
    }
