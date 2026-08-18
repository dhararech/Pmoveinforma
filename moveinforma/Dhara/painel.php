<?php
session_start();
if(empty($_SESSION['admin_id'])){
    header('Location: login.php');
    exit;
}
$nomeAdmin = $_SESSION['admin_nome'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Move Informa - Painel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg move-navbar sticky-top">
        <div class="container-page d-flex justify-content-between align-items-center">
            <span class="navbar-brand mb-0">
                <img src="" alt=""><!--já voltamos-->
            </span>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small">Olá, <?= htmlspecialchars($nomeAdmin) ?></span>  
               <a href="logout.php" class="btn btn-move-ghost btn-sm">Sair</a>   
        </div>
        </div>
    </nav>
    <main class="container-page py-4">
        <h1 class="section-title">Painel administrativo</h1>
        <p class="section-subtitle">O que você quer gerenciar</p>

        <div class="row g-4">
            <div class="col-sm-6 col-lg-4">
                <a href="notocias.php" class="text-decoration-none text-reset">
                    <div class="move-card p-4">
                        <h5 class="card-title">Notícias</h5>
                        <p class="card-text text-muted small mb-0">Cadastrar e editar as noticias da home e dos favoritos.</p>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-4">
                <a href="notocias.php" class="text-decoration-none text-reset">
                    <div class="move-card p-4">
                        <h5 class="card-title">Glossário</h5>
                        <p class="card-text text-muted small mb-0">Cadastrar e editar os termos do glossário.</p>
                    </div>
                </a>
            </div>
        </div>
</main>
</body>
</html>
