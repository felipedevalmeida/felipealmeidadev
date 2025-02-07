<?php
require 'config.php';
if (!is_logged_in()) {
    redirect('login.php');
}

$stmt = $pdo->query("SELECT * FROM content ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gerenciar Posts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1>Gerenciar Posts</h1>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Voltar</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="delete_post.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>