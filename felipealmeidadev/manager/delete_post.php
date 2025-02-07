<?php
require 'config.php';
if (!is_logged_in()) {
    redirect('login.php');
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM content WHERE id = ?");
$stmt->execute([$id]);
log_activity("Post deletado: $id");
redirect('manage_posts.php');