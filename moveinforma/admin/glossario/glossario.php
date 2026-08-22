<?php
session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require __DIR__ . '/../config/db.php';

$categorias = ["ti" => "TI", "industria" => "Indústria", "saude" => "Saúde", "educacao" => "Educação"];

//cadastrar
if ($_SERVER['REQUEST_METHOD'] === 'post') {
    $termo = trim($_POST['termo'] ?? '');
    $definicao = trim($_POST['definicao'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $disponivel_offline = trim($_POST['disponivel_offline'] ?? '') ? 1 : 0;
    if ($termo === '' || $definicao === '' || !array_key_exists($categoria, $categorias)) {
        $erro = "Preencha o termo, a definição e escolha uma categoria válida";
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO termos_glossario (termo, definicao, categoria, disponivel_offline) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$termo, $definicao, $categoria, $disponivel_offline]);
        header('Location: glossario.php');
        exit;
    }
}

//listar
$stmt = $pdo->query('SELECT * FROM termos_glossario ORDER BY id DESC');
$termos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Move Informa - Admin - Glossário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-lg move-navbar sticky-top">
        <div class="container-page d-flex justify-content-between align-items-center">
            <span class="navbar-brand mb-0"><img src="../assets/logo.svg" alt="" class="brand-logo">Move Informa -
                Admin</span>
            <div class="d-flex align-items-center gap-3">
                <a href="painel.php" class="link-muted text-decoration-none small"><- Painel</a>

                        <a href="logout.php" class="btn btn-move-ghost btn-sm">Sair</a>
            </div>
        </div>
    </nav>
    <main class="container-page py-4">
        <h1 class="section-title">Glossário</h1>
        <p class="section-subtitle">Cadastre novos termos e gerencie os já existentes.</p>

        <?php if ($erro): ?>
            <div class="alert alert-danger py-2 small"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
        <!--Formulário de cadastro-->
        <div class="move-card p-4 mb-5">
            <h5 class="mb-3">Novo termo</h5>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Termo</label>
                    <input type="text" name="termo" class="form-control" require>
                </div>
                <div class="mb-3">
                    <label class="form-label">Definição</label>
                    <textarea type="text" name="definicao" class="form-control" rows="2"  require></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Categoria</label>
                    <select name="categoria" class="form-select" require>
                        <option value="">Selecione...</option>
                        <?php foreach ($categorias as $valor=>$rotulo): ?>
                            <option value="<?= $valor ?>"><?= $rotulo ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="disponivel_offline" id="disponivel_offline">
                        <label class="form-check-label" for="disponivel_offline">Disponível Offline</label>
                </div>         
                <button type="submit" class="btn btn-move-primary">Cadastrar Termo</button>       
            </form>
        </div>
        <!--Lista de termo-->
        <h5 class="mb-3">Termo Cadastrados</h5>
        <?php if(empty($termos)): ?>
            <p class="text-muted">Nenhum termo cadastrado ainda.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Termo</th>
                            <th>Categoria</th>
                            <th>Offline</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($termos as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['termo']) ?></td>
                                <td><span
                                class="badge-category badge-<?= $item['categoria']?>"><?=$categorias[$item['categoria']] ?? $item['categoria'] ?></span></td>
                                <td><?= $item['disponivel_offline'] ?'sim': '-' ?></td>
                                <td class="text-end">
                                    <a href="glossario_editar.php?id<?= $item['id']?>" class="btn btn-move-outline btn-sm">Editar</a>
                                    <a href="excluir.php?id<?= $item['id']?>" class="btn btn-move-ghost btn-sm" onclick="return confirm('Tem certeza que deseja excluir esse termo?');">Excluir</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>  
            <?php endif; ?>  
    </main>
</body>
</html>