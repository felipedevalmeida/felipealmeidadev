<?php
require 'config.php';
if (!is_logged_in()) {
    redirect('login.php');
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM content WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$post) {
    die("Post não encontrado!");
}

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $status = $_POST['status'];

    $updateStmt = $pdo->prepare("UPDATE content SET title = ?, content = ?, category = ?, status = ?, updated_at = NOW() WHERE id = ?");
    $updateStmt->execute([$title, $content, $category, $status, $id]);
    log_activity("Post atualizado: $title");
    redirect('manage_posts.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1>Editar Post</h1>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="mb-3">
            <label class="form-label">Título:</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Conteúdo:</label>
            <textarea name="content" rows="5" class="form-control" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Categoria:</label>
            <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($post['category']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Status:</label>
            <select name="status" class="form-select">
                <option value="rascunho" <?php if($post['status']==='rascunho'){echo 'selected';} ?>>Rascunho</option>
                <option value="publicado" <?php if($post['status']==='publicado'){echo 'selected';} ?>>Publicado</option>
                <option value="agendado" <?php if($post['status']==='agendado'){echo 'selected';} ?>>Agendado</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
        <a href="manage_posts.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>