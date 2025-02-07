<?php
require 'config.php';
if (!is_logged_in()) {
    redirect('login.php');
}
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
$stmt->execute([$id]);
log_activity("Comentário excluído: $id");
redirect('manage_comments.php');