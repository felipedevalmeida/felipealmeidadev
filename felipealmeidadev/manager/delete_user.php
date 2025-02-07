<?php
require 'config.php';
if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);
log_activity("Usuário deletado: $id");
redirect('manage_users.php');