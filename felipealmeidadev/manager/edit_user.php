<?php
require 'config.php';
if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    die("Usuário não encontrado");
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $up = $pdo->prepare("UPDATE users SET name = ?, password = ?, role = ? WHERE id = ?");
        $up->execute([$name, $password, $role, $id]);
    } else {
        $up = $pdo->prepare("UPDATE users SET name = ?, role = ? WHERE id = ?");
        $up->execute([$name, $role, $id]);
    }
    log_activity("Usuário atualizado: $name");
    redirect('manage_users.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1>Editar Usuário</h1>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Senha (deixe em branco para não alterar):</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Função:</label>
            <select name="role" class="form-select">
                <option value="admin" <?php if($user['role']==='admin'){echo 'selected';} ?>>Admin</option>
                <option value="editor" <?php if($user['role']==='editor'){echo 'selected';} ?>>Editor</option>
                <option value="author" <?php if($user['role']==='author'){echo 'selected';} ?>>Author</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Salvar</button>
        <a href="manage_users.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>