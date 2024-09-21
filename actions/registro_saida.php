<?php

require_once '../config/connect.php'; // nao sei qual o script certo que vao usar pra conectar mas deixei como exemplo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['plate_exit'], $_POST['exit_time'])) {
        $placa = $_POST['plate_exit'];
        $horaSaida = $_POST['exit_time'];

        
        $sqlVeiculo = "SELECT * FROM VEICULOS WHERE PLACA = :placa AND SAIDA IS NULL";
        $stmt = $pdo->prepare($sqlVeiculo);
        $stmt->bindValue(':placa', $placa);
        $stmt->execute();
        $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($veiculo) {
            $horaEntrada = $veiculo['ENTRADA'];
            $tipoVeiculo = $veiculo['VEI_TIPO'];

         
            $tempoEntrada = new DateTime($horaEntrada);
            $tempoSaida = new DateTime($horaSaida);
            $intervalo = $tempoSaida->diff($tempoEntrada);
            $horasPermanencia = $intervalo->h + ($intervalo->i > 0 ? 1 : 0); 

            
            $sqlTarifa = "SELECT TAR_INICIAL, TAR_HORA FROM TARIFA WHERE TAR_TIPO = :tipo";
            $stmtTarifa = $pdo->prepare($sqlTarifa);
            $stmtTarifa->bindValue(':tipo', $tipoVeiculo);
            $stmtTarifa->execute();
            $tarifa = $stmtTarifa->fetch(PDO::FETCH_ASSOC);

            if ($tarifa) {
                $tarifaInicial = $tarifa['TAR_INICIAL'];
                $tarifaHora = $tarifa['TAR_HORA'];

               
                $valorTotal = $tarifaInicial + ($horasPermanencia - 1) * $tarifaHora;

                
                $sqlUpdate = "UPDATE VEICULOS 
                              SET SAIDA = :saida, TEMPO = :tempo, VALOR = :valor 
                              WHERE ID = :id";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                $stmtUpdate->bindValue(':saida', $horaSaida);
                $stmtUpdate->bindValue(':tempo', $horasPermanencia);
                $stmtUpdate->bindValue(':valor', $valorTotal);
                $stmtUpdate->bindValue(':id', $veiculo['ID']);

                try {
                    $stmtUpdate->execute();
                    echo "Saída registrada com sucesso! Valor total: R$ " . number_format($valorTotal, 2);
                } catch (PDOException $e) {
                    echo "Erro ao registrar a saída: " . $e->getMessage();
                }
            } else {
                echo "Tarifa não encontrada para o tipo de veículo.";
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

?>
