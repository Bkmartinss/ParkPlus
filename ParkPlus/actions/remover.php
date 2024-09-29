<?php
require_once '../config/connect.php'; // Inclui a conexão com o banco de dados

if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];

    // Remover o veículo da base de dados
    try {
        $sql = "DELETE FROM VEICULOS WHERE PLACA = :placa";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['placa' => $placa]);
        header("Location: ../administracao.php?success=Veículo removido com sucesso.");
    } catch (PDOException $e) {
        die("Erro ao remover veículo: " . $e->getMessage());
    }
} else {
    die("Placa do veículo não informada.");
}
?>
