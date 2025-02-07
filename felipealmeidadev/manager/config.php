<?php
$host = 'localhost';
$dbname = 'cms_database';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

session_start();

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function log_activity($message) {
    global $pdo;
    if (!isset($_SESSION['user_id'])) return;
    $stmt = $pdo->prepare("INSERT INTO logs (user_id, ip_address, action, message, created_at) VALUES (?, ?, ?, ?, NOW())");
    $action = debug_backtrace()[1]['function'] ?? 'unknown';
    $stmt->execute([
        $_SESSION['user_id'],
        $_SERVER['REMOTE_ADDR'],
        $action,
        $message
    ]);
}

function redirect($url) {
    header("Location: $url");
    exit;
}

// Proteção contra CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Ação não permitida (CSRF)");
    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>