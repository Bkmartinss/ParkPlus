<?php

require_once '../config/connect.php';
echo "Método atual: " . $_SERVER["REQUEST_METHOD"]; // Verifica o método da requisição

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "entrei";
    // Valida se os campos estão definidos
    if (isset($_POST['plate'], $_POST['entry-time'], $_POST['vehicle-type'])) {
        $placa = $_POST['plate'];
        $entrada = $_POST['entry-time'];
        $tipo = $_POST['vehicle-type'];

        var_dump($_POST); // Para depuração

        $sql = "INSERT INTO VEICULOS (PLACA, ENTRADA, VEI_TIPO) VALUES (:placa, :entrada, :tipo)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':placa', $placa);
        $stmt->bindValue(':entrada', $entrada);
        $stmt->bindValue(':tipo', $tipo);

        try {
            $stmt->execute();
            echo "Veículo cadastrado com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao cadastrar veículo: " . $e->getMessage(); // Exibir erro
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>