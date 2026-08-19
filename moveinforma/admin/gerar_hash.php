<?php

$senha = '123456'; //colocar a senha que quiser
$hash = password_hash($senha, PASSWORD_DEFAULT);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar hash de senha</title>
</head>
<body style="font-family: monospace;">
    <h1>hash gerado</h1>
    <p>Senha original: <strong><?= htmlspecialchars($hash) ?></strong></p>
    <p>hash: <strong><?= htmlspecialchars($hash)?></strong></p>

    <hr>
    <p>Agora Vá no phpMyAdmin, aba SQL do banco, e rode (trocando o e-mail e o nome pelos seus, e colando o hash acima no lugar indicado):</p>
    <pre>INSERT INTO administradores(nome, email, senha_hash) VALUES ('Dhara', 'dhara@moveinforma.com', '<?= htmlspecialchars($hash)?>');</pre>
    <p>Depois disso, é só usar dhara@moveinforma.com e a senha <?= htmlspecialchars($senha)?> para logar em admim/login.php</p>
</body>
</html>
