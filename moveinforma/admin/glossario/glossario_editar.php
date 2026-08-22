<?php
session_start();
if (empty($SESSION['admin_id'])){
    header('Location: login.php');
    exit;
}
require __DIR__ . '/../config/db.php';

$categorias = ["ti" => "TI", "industria" => "Indústria", "saude" => "Saúde", "educacao" => "Educação"];

$id = (int) ($_GET['id'] ?? 0)
if ($id === 0){
    header('Location: glossario.php')
    exit;
}

$erro = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $termo = trim($_POST['termo'] ?? '');
    $definicao = trim($_POST['definicao'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $disponivel_offline = trim($_POST['disponivel_offline']) ? 1 : 0;

 if ($termo === '' || $definicao === '' || !array_key_exists($categoria, $categorias))
     { 
        $erro = "Preencha o termo, a definição e escolha uma categoria válida";
    } else {
        $stmt = $pdo->prepare(
            'UPDATE termos_glossario
            SET termo = ?, definicao = ?, categoria = ?, disponivel_offline = ?
            WHERE id = ?'
        );
            $stmt->execute([$termo, $definicao, $categoria, $disponivel_offline, $id]);
            header('Location: glossario.php')
            exit;
        }
    }
    if ($_SESSION['REQUEST_METHOD'] !== 'POST'){
        $stmt = $pdo->prepare('SELECT * FROM termos_glossario WHERE id = ?');
        $stmt->execute([$id]);
        $item = $stmt->fetch();

        if(!$item){
            header('Location: glossario.php')
            exit;
        }
    }else{
        $item = [
            'id' =>$id,
            'termo' => $termo,
            'definicao' => $definicao,
            'categoria' => $categoria,
            'disponivel_offline' => $disponivel_offline
        ];
    }
    ?>

    <!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Move Informa — Admin — Editar termo</title>
  <link rel="icon" type="image/svg+xml" href="../assets/logo.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>

  <nav class="navbar navbar-expand-lg move-navbar sticky-top">
    <div class="container-page d-flex justify-content-between align-items-center">
      <span class="navbar-brand mb-0"><img src="../assets/logo.svg" alt="" class="brand-logo">Move Informa — Admin</span>
      <div class="d-flex align-items-center gap-3">
        <a href="glossario.php" class="link-muted text-decoration-none small">← Glossário</a>
        <a href="logout.php" class="btn btn-move-ghost btn-sm">Sair</a>
      </div>
    </div>
  </nav>

  <main class="container-page py-4" style="max-width:640px;">
    <h1 class="section-title">Editar termo</h1>

    <div class="alert alert-danger py-2 small">Mensagem de erro de exemplo</div>

    <div class="move-card p-4">
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Termo</label>
          <input type="text" name="termo" class="form-control" required value="Exemplo de Termo">
        </div>
        <div class="mb-3">
          <label class="form-label">Definição</label>
          <textarea name="definicao" class="form-control" rows="2" required>Exemplo de definição do termo.</textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Categoria</label>
          <select name="categoria" class="form-select" required>
            <option value="ti">TI</option>
            <option value="industria">Indústria</option>
            <option value="saude">Saúde</option>
            <option value="educacao">Educação</option>
          </select>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="disponivel_offline" id="disponivel_offline">
          <label class="form-check-label" for="disponivel_offline">Disponível offline</label>
        </div>

        <button type="submit" class="btn btn-move-primary">Salvar alterações</button>
        <a href="glossario.php" class="btn btn-move-ghost">Cancelar</a>
      </form>
    </div>
  </main>

</body>
</html>