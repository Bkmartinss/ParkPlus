<?php
session_start();
require_once '../config/connect.php';

if (isset($_GET['plate']) && isset($_GET['exit_time'])) {
    $plate = $_GET['plate'];
    $exitTime = $_GET['exit_time'];

 
    $sql = "SELECT ENTRADA, VEI_TIPO FROM veiculos WHERE PLACA = :plate";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['plate' => $plate]);
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($vehicle) {
        $entryTime = $vehicle['ENTRADA'];
        $vehicleType = $vehicle['VEI_TIPO'];

 
        $entryDateTime = new DateTime($entryTime);
        $exitDateTime = new DateTime($exitTime);
        $interval = $exitDateTime->diff($entryDateTime);
        $hours = $interval->h + ($interval->i > 0 ? 1 : 0); 

     
        switch ($vehicleType) {
            case 1: // Moto
                $initialRate = 2.00;
                $hourlyRate = 2.00;
                break;
            case 2: // Carro de Passeio
                $initialRate = 4.00;
                $hourlyRate = 2.00;
                break;
            case 3: // Caminhonete
                $initialRate = 6.00;
                $hourlyRate = 2.00;
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Tipo de veículo inválido.']);
                exit;
        }


        if ($hours <= 1) {
            $totalAmount = $initialRate;
        } else {
            $totalAmount = $initialRate + ($hours - 1) * $hourlyRate;
        }

     
        $sqlUpdate = "UPDATE VEICULOS 
                      SET SAIDA = :saida, TEMPO = :tempo, VALOR = :valor 
                      WHERE PLACA = :plate";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':saida' => $exitTime,
            ':tempo' => $hours,
            ':valor' => $totalAmount,
            ':plate' => $plate
        ]);

        echo json_encode([
            'success' => true,
            'horaEntrada' => $entryTime,
            'horaSaida' => $exitTime,
            'tempoPermanencia' => $hours,
            'valorTotal' => $totalAmount
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Veículo não encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Placa ou hora de saída não fornecidas.']);
}
?>
