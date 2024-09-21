<?php
session_start();
require_once '../config/connect.php';

if (isset($_GET['plate'])) {
    $plate = $_GET['plate'];

    $sql = "SELECT ENTRADA, TIPO_VEICULO FROM veiculos WHERE PLACA = :plate";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['plate' => $plate]);
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($vehicle) {
        echo json_encode([
            'success' => true,
            'horaEntrada' => $vehicle['ENTRADA'],
            'tipoVeiculo' => $vehicle['TIPO_VEICULO'],
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Veículo não encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Placa não fornecida.']);
}
?>