<?php
require 'config.php';
if (!is_logged_in()) {
    redirect('login.php');
}
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("UPDATE comments SET status='aprovado' WHERE id = ?");
$stmt->execute([$id]);
log_activity("Comentário aprovado: $id");
redirect('manage_comments.php');