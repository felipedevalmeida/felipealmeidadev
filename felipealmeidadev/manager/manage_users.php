<?php
require 'config.php';
if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gerenciar Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1>Gerenciar Usuários</h1>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Voltar</a>

    <?php
    $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Função</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($usr = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($usr['name']); ?></td>
                <td><?php echo htmlspecialchars($usr['email']); ?></td>
                <td><?php echo $usr['role']; ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $usr['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="delete_user.php?id=<?php echo $usr['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="add_user.php" class="btn btn-primary">Adicionar Novo Usuário</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>