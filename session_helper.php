<?php
// Cookie-based session persistence for Serverless / Cloud environments
define('LUMOO_AUTH_SECRET', 'lumoo_coffee_jwt_secret_token_2026_xyz');

function lumoo_save_auth_cookie($id, $level, $nama) {
    $payload = json_encode([
        'id'    => $id,
        'level' => $level,
        'nama'  => $nama,
        'time'  => time()
    ]);
    $sig = hash_hmac('sha256', $payload, LUMOO_AUTH_SECRET);
    $val = base64_encode($payload . '::' . $sig);
    setcookie('lumoo_auth', $val, time() + 86400 * 7, '/', '', false, true);
}

function lumoo_restore_auth_session() {
    if (empty($_SESSION['status_login']) && !empty($_COOKIE['lumoo_auth'])) {
        $raw = base64_decode($_COOKIE['lumoo_auth']);
        if ($raw && str_contains($raw, '::')) {
            $parts = explode('::', $raw, 2);
            if (count($parts) === 2) {
                $payload = $parts[0];
                $sig = $parts[1];
                if (hash_equals(hash_hmac('sha256', $payload, LUMOO_AUTH_SECRET), $sig)) {
                    $data = json_decode($payload, true);
                    if (!empty($data['id']) && !empty($data['level'])) {
                        $_SESSION['id_login']     = $data['id'];
                        $_SESSION['level']        = $data['level'];
                        $_SESSION['status_login'] = true;
                        $_SESSION['nama']         = $data['nama'] ?? '';
                    }
                }
            }
        }
    }
}

function lumoo_clear_auth_cookie() {
    setcookie('lumoo_auth', '', time() - 42000, '/', '', false, true);
    if (isset($_COOKIE['lumoo_auth'])) {
        unset($_COOKIE['lumoo_auth']);
    }
}
