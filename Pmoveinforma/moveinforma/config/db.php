<?php
$host = 'localhost';
$dbname = 'moveinforma'; // nome do banco de dados
$user = 'root'; // usuário do bd criado automaticamente pelo XAMPP
$senha = ''; //senha vazia no localhost
try{
    $pdo = new PDO(
        "mysql:host={$host}; dbname={$dbname};charset=utf8mb4",
        $user, //usuario que fará login no banco
        $senha, // senha desse usuário

        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

            PDO::ATTR_DEFAULT_FETCH_MODE => PDO :: FETCH_ASSOC,

            PDO::ATTR_EMULATE_PREPARES => false,
        ]
        );
}catch(PDOException $e){
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>