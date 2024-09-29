<?php
require_once '../config/connect.php'; // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placa = $_POST['placa'];
    $entrada = $_POST['entrada'];
    $saida = $_POST['saida'];
    $valor = $_POST['valor'];

    // Atualizar os dados do veículo
    try {
        $sql = "UPDATE VEICULOS SET ENTRADA = :entrada, SAIDA = :saida, VALOR = :valor WHERE PLACA = :placa";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'entrada' => $entrada,
            'saida' => $saida,
            'valor' => $valor,
            'placa' => $placa
        ]);
        header("Location: ../administracao.php?success=Veículo atualizado com sucesso.");
    } catch (PDOException $e) {
        die("Erro ao atualizar veículo: " . $e->getMessage());
    }
} else {
    die("Método de requisição inválido.");
}
?>
