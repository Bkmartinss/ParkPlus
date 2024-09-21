<?php

require_once '../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['plate'], $_POST['entry-time'], $_POST['vehicle-type'])) {
        $placa = trim($_POST['plate']);
        $entrada = $_POST['entry-time'];
        $tipo = $_POST['vehicle-type'];

        // Validação da placa (exemplo: formato esperado ABC1D23)
        if (!preg_match("/^[A-Z]{3}[0-9][A-Z][0-9]{2}$/", $placa)) {
            echo "Formato da placa inválido. Utilize o formato ABC1D23.";
            exit;
        }

        $sql = "INSERT INTO VEICULOS (PLACA, ENTRADA, VEI_TIPO) VALUES (:placa, :entrada, :tipo)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':placa', $placa);
        $stmt->bindValue(':entrada', $entrada);
        $stmt->bindValue(':tipo', $tipo);

        try {
            $stmt->execute();
            echo "<div class='alert alert-success'>Veículo cadastrado com sucesso!</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erro ao cadastrar veículo: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Por favor, preencha todos os campos.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Método de requisição inválido.</div>";
}
?>