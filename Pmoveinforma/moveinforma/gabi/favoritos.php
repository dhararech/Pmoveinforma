<?php
require __DIR__ . '/../config/db.php';
$stmt = $pdo->prepare("SELECT * FROM noticias WHERE favorito = 1");
$stmt->execute();
$favoritos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Move Informa — Favoritos</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="../css/style.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="../img/favicon.png">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg move-navbar sticky-top">
    <div class="container-page d-flex flex-wrap">
      <a class="navbar-brand" href="../pietro/pagInicial.html"><span class="dot"></span>Move Informa</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMove" aria-controls="navbarMove" aria-expanded="false" aria-label="Abrir menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarMove">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="../pietro/pagInicial.html">Início</a></li>
          <li class="nav-item"><a class="nav-link" href="../leandro/Glossario.html">Glossário</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Mapa</a></li>
          <li class="nav-item"><a class="nav-link active" aria-current="page" href="favoritos.html">Favoritos</a></li>
          <li class="nav-item"><a class="nav-link" href="../pedro/offline.html">Offline</a></li>
        </ul>
        <form class="d-flex" role="search" onsubmit="return false;">
          <input class="form-control me-2 btn-search" type="search" placeholder="Buscar um termo" aria-label="Buscar">
          <button class="btn btn-move-primary" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>

  <main class="container-page py-4 position-relative">
    <button type="button" class="btn btn-move-ghost btn-float-close" data-go-home>← Voltar</button>

    <h1 class="section-title">Favoritos</h1>
    <p class="section-subtitle">Os termos e conteúdos que você marcou para revisar depois.</p>

    <div class="filter-bar">
      <button type="button" class="btn btn-move-outline active" data-filter="todos">Todos</button>
      <button type="button" class="btn btn-move-outline" data-filter="programacao">Programação</button>
      <button type="button" class="btn btn-move-outline" data-filter="saude">Saúde</button>
    </div>
    <div class="row g-4">
    <?php foreach ($favoritos as $item): ?>
    <div class="col-md-6 col-lg-4">
    <div class="move-card overflow-hidden">
    <img src="<?= htmlspecialchars($item['imagem_url']) ?>" class="card-img-top" style="height:170px;object-fit:cover;" alt="">
    <div class="card-body p-4">
    <h5 class="card-title mt-2"><?= htmlspecialchars($item['titulo']) ?></h5>
    <p class="card-text text-muted small"><?= htmlspecialchars($item['resumo']) ?></p>
    </div>
    </div>
    </div>
    <?php endforeach; ?>
    </div>

    <div class="move-empty mt-4" data-empty-state style="display:none;">
      Nenhum favorito nessa categoria ainda.
    </div>
  </main>

  <footer class="move-footer">
    <div class="container-page d-flex flex-wrap justify-content-between gap-2">
      <span>© 2026 Move Informa</span>
      <span>Desenvolvido por Senac RS Caxias do Sul - Todos os direitos reservados</span>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/script.js"></script>
</body>
</html>
