<?php
require_once '../config/connect.php';
session_start(); // Inicie a sessão aqui

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['plate_exit'], $_POST['exit_time'])) {
        $placa = $_POST['plate_exit'];
        $horaSaida = date('Y-m-d H:i:s', strtotime($_POST['exit_time'])); // Formata a hora

        // Consulta para verificar se o veículo está na tabela e não saiu
        $sqlVeiculo = "SELECT * FROM VEICULOS WHERE PLACA = :placa AND SAIDA IS NULL";
        $stmt = $pdo->prepare($sqlVeiculo);
        $stmt->bindValue(':placa', $placa);
        $stmt->execute();
        $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($veiculo) {
            // Atualiza a saída do veículo
            $sqlUpdate = "UPDATE VEICULOS SET SAIDA = :saida WHERE ID = :id";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->bindValue(':saida', $horaSaida);
            $stmtUpdate->bindValue(':id', $veiculo['ID']);

            try {
                $stmtUpdate->execute();
                echo "Saída registrada com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao registrar a saída: " . $e->getMessage();
            }
        } else {
            echo "Veículo não encontrado ou já registrado como saído.";
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    echo "Método de requisição inválido.";
}

// Consultar veículos que ainda não saíram
$sqlVeiculos = "SELECT PLACA FROM VEICULOS WHERE SAIDA IS NULL";
$stmtVeiculos = $pdo->prepare($sqlVeiculos);
$stmtVeiculos->execute();
$veiculosList = $stmtVeiculos->fetchAll(PDO::FETCH_ASSOC);

// Salva a lista de placas em uma variável de sessão
$_SESSION['veiculosList'] = $veiculosList;
