<?php
require 'config.php';
if (!is_logged_in()) {
    redirect('login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gerenciar Comentários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1>Gerenciar Comentários</h1>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Voltar</a>

    <?php
    $stmt = $pdo->query("SELECT c.*, ct.title as post_title FROM comments c JOIN content ct ON c.post_id = ct.id ORDER BY c.created_at DESC");
    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Autor</th>
                <th>Post</th>
                <th>Comentário</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($comment = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($comment['author_name']); ?></td>
                <td><?php echo htmlspecialchars($comment['post_title']); ?></td>
                <td><?php echo htmlspecialchars($comment['content']); ?></td>
                <td><?php echo $comment['status']; ?></td>
                <td>
                    <a href="approve_comment.php?id=<?php echo $comment['id']; ?>" class="btn btn-sm btn-success">Aprovar</a>
                    <a href="delete_comment.php?id=<?php echo $comment['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>