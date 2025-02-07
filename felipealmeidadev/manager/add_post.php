<?php
require 'config.php';
if (!is_logged_in()) {
    redirect('login.php');
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $status = $_POST['status'] ?? 'rascunho';

    $stmt = $pdo->prepare("INSERT INTO content (title, content, category, status, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$title, $content, $category, $status]);

    log_activity("Post criado: $title");
    redirect('manage_posts.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Novo Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h1 class="mb-4">Novo Post</h1>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="mb-3">
            <label class="form-label">Título:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Conteúdo:</label>
            <textarea name="content" rows="5" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Categoria:</label>
            <input type="text" name="category" class="form-control" placeholder="Ex: Tecnologia">
        </div>
        <div class="mb-3">
            <label class="form-label">Status:</label>
            <select name="status" class="form-select">
                <option value="rascunho">Rascunho</option>
                <option value="publicado">Publicado</option>
                <option value="agendado">Agendado</option>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Salvar</button>
        <a href="dashboard.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>