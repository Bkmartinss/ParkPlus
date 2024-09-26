<?php
require_once "../config/connect.php"; // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plate = $_POST['plate_exit'];
    $exitTime = $_POST['exit_time'];

    // Verifica se a placa e a hora de saída foram fornecidas
    if (empty($plate) || empty($exitTime)) {
        die("Placa ou hora de saída não fornecida.");
    }

    // Atualiza a tabela de veículos com a hora de saída
    try {
        // Consulta para buscar a hora de entrada e o tipo do veículo
        $sql = "SELECT ENTRADA, VEI_TIPO FROM VEICULOS WHERE PLACA = :placa";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':placa', $plate);
        $stmt->execute();
        $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$veiculo) {
            die("Veículo não encontrado.");
        }

        // Calcula o tempo de permanência
        $entrada = new DateTime($veiculo['ENTRADA']);
        $saida = new DateTime($exitTime);
        $intervalo = $entrada->diff($saida);
        $tempoPermanencia = $intervalo->h + ($intervalo->i > 0 ? 1 : 0); // Arredonda para cima

        // Atualiza o tempo de permanência e a hora de saída no banco de dados
        $sqlUpdate = "UPDATE VEICULOS SET SAIDA = :saida, TEMPO = :tempo WHERE PLACA = :placa";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':saida', $exitTime);
        $stmtUpdate->bindParam(':tempo', $tempoPermanencia);
        $stmtUpdate->bindParam(':placa', $plate);
        $stmtUpdate->execute();

        // Busca a tarifa de acordo com o tipo de veículo
        $sqlTarifa = "SELECT TAR_INICIAL, TAR_HORA FROM TARIFA WHERE TAR_TIPO = :tipo";
        $stmtTarifa = $pdo->prepare($sqlTarifa);
        $stmtTarifa->bindParam(':tipo', $veiculo['VEI_TIPO']);
        $stmtTarifa->execute();
        $tarifa = $stmtTarifa->fetch(PDO::FETCH_ASSOC);

        if (!$tarifa) {
            die("Tarifa não encontrada.");
        }

        // Calcula o valor total
        $valorTotal = $tarifa['TAR_INICIAL'] + ($tempoPermanencia > 1 ? ($tempoPermanencia - 1) * $tarifa['TAR_HORA'] : 0);

        // Atualiza o valor no banco de dados
        $sqlUpdateValor = "UPDATE VEICULOS SET VALOR = :valor WHERE PLACA = :placa";
        $stmtUpdateValor = $pdo->prepare($sqlUpdateValor);
        $stmtUpdateValor->bindParam(':valor', $valorTotal);
        $stmtUpdateValor->bindParam(':placa', $plate);
        $stmtUpdateValor->execute();

        echo "Saída registrada com sucesso. Valor total: R$ " . number_format($valorTotal, 2, ',', '.');
    } catch (PDOException $e) {
        die("Erro ao registrar saída: " . $e->getMessage());
    }
}
?>
