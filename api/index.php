<?php
// Set temporary session save path for Serverless / Cloud environments
$tmpSession = sys_get_temp_dir() . '/php_sessions';
if (!is_dir($tmpSession)) {
    @mkdir($tmpSession, 0777, true);
}
if (is_dir($tmpSession) && is_writable($tmpSession)) {
    @session_save_path($tmpSession);
}

$rootDir = dirname(__DIR__);

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = rawurldecode($uri);
$uri = ltrim($uri, '/');

if ($uri === '' || $uri === 'index.php') {
    chdir($rootDir);
    require $rootDir . '/index.php';
    exit;
}

$targetFile = realpath($rootDir . '/' . $uri);

// Prevent directory traversal attacks
if ($targetFile && str_starts_with($targetFile, $rootDir) && is_file($targetFile)) {
    $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    if ($ext === 'php') {
        chdir(dirname($targetFile));
        require $targetFile;
        exit;
    }
    
    // Fallback static mime types
    $mimes = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'webp' => 'image/webp',
        'ico'  => 'image/x-icon',
        'sql'  => 'text/plain'
    ];
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
    }
    readfile($targetFile);
    exit;
}

http_response_code(404);
echo "404 Not Found";
