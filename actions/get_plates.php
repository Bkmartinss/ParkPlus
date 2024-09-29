<?php
require_once '../config/connect.php';

$sql = "SELECT PLACA FROM VEICULOS WHERE SAIDA IS NULL";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($veiculos);