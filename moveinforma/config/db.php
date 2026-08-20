<?php

$host = 'localhost';
$dbname = 'moveinforma';
$user = 'root';
$senha = '';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $user,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    echo "Conectado com sucesso!";

} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}