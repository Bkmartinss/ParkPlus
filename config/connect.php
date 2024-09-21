<?php
//arquivo de conexão com o banco de dados

$host = "localhost";
$dbname = "parkplus_db"; //nome do banco
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=parkplus_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida!!"; // Para verificar a conexão
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
