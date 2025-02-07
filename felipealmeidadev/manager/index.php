<?php
require 'config.php';
$stmt = $pdo->query("SELECT * FROM content WHERE status = 'publicado' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Site Teste</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Meu Site</a>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Bem-vindo ao Site Teste</h1>
    <div class="row">
    <?php while($post = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                    <p class="card-text">
                        <?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 200))); ?>...
                    </p>
                    <a href="view_post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Ler Mais</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>