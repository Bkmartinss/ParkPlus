<?php
require_once '../config/connect.php';

// Consulta SQL para selecionar as informações necessárias
$sql = "SELECT PLACA, ENTRADA, VEI_TIPO FROM VEICULOS WHERE SAIDA IS NULL";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mapeia os tipos de veículo
foreach ($veiculos as &$veiculo) {
    switch ($veiculo['VEI_TIPO']) {
        case 1:
            $veiculo['VEI_TIPO'] = 'Moto';
            break;
        case 2:
            $veiculo['VEI_TIPO'] = 'Carro';
            break;
        case 3:
            $veiculo['VEI_TIPO'] = 'Caminhonete';
            break;
        default:
            $veiculo['VEI_TIPO'] = 'Desconhecido'; // Para garantir que todos os casos sejam tratados
            break;
    }
}

header('Content-Type: application/json');
echo json_encode($veiculos);
