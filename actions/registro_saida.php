<?php
session_start();

// Conexão com o banco de dados
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'parkplus_db';

// Cria a conexão
$conn = new mysqli($host, $user, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placa = $_POST['plate_exit'] ?? null;
    $horaSaida = $_POST['exit_time'] ?? null;

    // Busca o veículo pela placa que ainda não tem hora de saída registrada
    $queryVeiculo = "SELECT * FROM VEICULOS WHERE PLACA = ? AND SAIDA IS NULL";
    $stmtVeiculo = $conn->prepare($queryVeiculo);
    $stmtVeiculo->bind_param("s", $placa);
    $stmtVeiculo->execute();
    $resultVeiculo = $stmtVeiculo->get_result();

    if ($resultVeiculo->num_rows > 0) {
        $veiculo = $resultVeiculo->fetch_assoc();
        $horaEntrada = $veiculo['ENTRADA'];
        $tipoVeiculo = $veiculo['VEI_TIPO'];

        // Calcula o tempo de permanência
        $tempoEntrada = new DateTime($horaEntrada);
        $tempoSaida = new DateTime($horaSaida);
        $intervalo = $tempoSaida->diff($tempoEntrada);
        $horasPermanencia = $intervalo->h + ($intervalo->i > 0 ? 1 : 0); // Considera frações de horas

        // Busca a tarifa correspondente ao tipo de veículo
        $queryTarifa = "SELECT TAR_INICIAL, TAR_HORA FROM TARIFA WHERE TAR_TIPO = ?";
        $stmtTarifa = $conn->prepare($queryTarifa);
        $stmtTarifa->bind_param("i", $tipoVeiculo);
        $stmtTarifa->execute();
        $resultTarifa = $stmtTarifa->get_result();

        if ($resultTarifa->num_rows > 0) {
            $tarifa = $resultTarifa->fetch_assoc();
            $tarifaInicial = $tarifa['TAR_INICIAL'];
            $tarifaHora = $tarifa['TAR_HORA'];

            // Calcula o valor total
            $valorTotal = $tarifaInicial + ($horasPermanencia - 1) * $tarifaHora;

            // Atualiza o veículo com a hora de saída, tempo e valor
            $queryUpdateVeiculo = "
                UPDATE VEICULOS 
                SET SAIDA = ?, TEMPO = ?, VALOR = ?
                WHERE ID = ?";
            $stmtUpdateVeiculo = $conn->prepare($queryUpdateVeiculo);
            $stmtUpdateVeiculo->bind_param("sidi", $horaSaida, $horasPermanencia, $valorTotal, $veiculo['ID']);
            $stmtUpdateVeiculo->execute();

            // Exibe o valor total para o usuário
            echo "Valor total a ser pago: R$" . number_format($valorTotal, 2);
        }
    } else {
        echo "Veículo não encontrado ou já registrado como saído.";
    }
}
