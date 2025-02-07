<?php
require 'config.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM content WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$post || $post['status'] !== 'publicado') {
    die("Post não encontrado ou não publicado.");
}

// Sistema de comentários
if (isset($_POST['comment_submit'])) {
    $author_name = $_POST['author_name'];
    $author_email = $_POST['author_email'];
    $content = $_POST['content'];

    $cmt = $pdo->prepare("INSERT INTO comments (post_id, author_name, author_email, content, status) VALUES (?, ?, ?, ?, 'pendente')");
    $cmt->execute([$id, $author_name, $author_email, $content]);
    echo "<div class='alert alert-success mt-3'>Comentário enviado para aprovação.</div>";
}

// Carregar comentários aprovados
$commentsStmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? AND status='aprovado' ORDER BY created_at DESC");
$commentsStmt->execute([$id]);
$comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Meu Site</a>
    </div>
</nav>

<div class="container mt-4">
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <div class="mb-4">
        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
    </div>
    <hr>

    <h3>Comentários Aprovados:</h3>
    <?php if(count($comments) > 0): ?>
        <ul class="list-group mb-4">
            <?php foreach($comments as $c): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($c['author_name']); ?></strong><br>
                    <?php echo nl2br(htmlspecialchars($c['content'])); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhum comentário ainda.</p>
    <?php endif; ?>

    <hr>
    <h3>Deixe seu comentário:</h3>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <input type="text" name="author_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="author_email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Comentário:</label>
            <textarea name="content" rows="4" class="form-control" required></textarea>
        </div>
        <button type="submit" name="comment_submit" class="btn btn-primary">Enviar</button>
    </form>

    <hr>
    <p><a href="index.php" class="btn btn-secondary">Voltar à Home</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>