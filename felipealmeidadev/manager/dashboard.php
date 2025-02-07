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
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">CMS Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage_posts.php">Posts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage_users.php">Usuários</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage_comments.php">Comentários</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Painel Administrativo</h1>
    <p>Bem-vindo, <strong><?php echo $_SESSION['user_name']; ?></strong>!</p>

    <div class="row g-4 mt-3">
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body">
                    <h5 class="card-title">Total de Conteúdos</h5>
                    <p class="card-text fs-4 text-info">
                        <?php echo $pdo->query("SELECT COUNT(*) FROM content")->fetchColumn(); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">Total de Usuários</h5>
                    <p class="card-text fs-4 text-success">
                        <?php echo $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title">Total de Comentários</h5>
                    <p class="card-text fs-4 text-warning">
                        <?php echo $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn(); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="add_post.php" class="btn btn-primary">Adicionar Novo Post</a>
        <a href="manage_posts.php" class="btn btn-secondary">Gerenciar Posts</a>
        <a href="manage_users.php" class="btn btn-secondary">Gerenciar Usuários</a>
        <a href="manage_comments.php" class="btn btn-secondary">Gerenciar Comentários</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>