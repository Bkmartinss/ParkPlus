<?php
require_once '../config/connect.php';
session_start();

$veiculoSaida = null;

// Verifica se foi passado um veículo via query string
if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];

    // Consulta para obter os dados do veículo
    $sqlVeiculo = "SELECT * FROM VEICULOS WHERE PLACA = :placa AND SAIDA IS NOT NULL";
    $stmt = $pdo->prepare($sqlVeiculo);
    $stmt->bindValue(':placa', $placa);
    $stmt->execute();
    $veiculoSaida = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ParkPlus - Informações do Veículo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center">Informações do Veículo</h2>

    <?php if ($veiculoSaida): ?>
      <p><strong>Placa:</strong> <?= htmlspecialchars($veiculoSaida['PLACA']); ?></p>
      <p><strong>Hora de Entrada:</strong> <?= htmlspecialchars($veiculoSaida['ENTRADA']); ?></p>
      <p><strong>Hora de Saída:</strong> <?= htmlspecialchars($veiculoSaida['SAIDA']); ?></p>
      
      <?php
      // Cálculo do tempo de permanência
      $tempoEntrada = new DateTime($veiculoSaida['ENTRADA']);
      $tempoSaida = new DateTime($veiculoSaida['SAIDA']);
      $intervalo = $tempoSaida->diff($tempoEntrada);
      $horasPermanencia = $intervalo->h + ($intervalo->i > 0 ? 1 : 0); // Arredonda para cima

      // Calcular tarifa (exemplo, pode ser ajustado conforme necessário)
      $tipoVeiculo = $veiculoSaida['VEI_TIPO'];
      $sqlTarifa = "SELECT TAR_INICIAL, TAR_HORA FROM TARIFA WHERE TAR_TIPO = :tipo";
      $stmtTarifa = $pdo->prepare($sqlTarifa);
      $stmtTarifa->bindValue(':tipo', $tipoVeiculo);
      $stmtTarifa->execute();
      $tarifa = $stmtTarifa->fetch(PDO::FETCH_ASSOC);

      $valorTotal = 0;
      if ($tarifa) {
          $tarifaInicial = $tarifa['TAR_INICIAL'];
          $tarifaHora = $tarifa['TAR_HORA'];

          $valorTotal = $tarifaInicial + ($horasPermanencia - 1) * $tarifaHora;
      }
      ?>
      
      <p><strong>Tempo de Permanência:</strong> <?= $horasPermanencia; ?> horas</p>
      <p><strong>Tarifa Calculada:</strong> R$ <?= number_format($valorTotal, 2); ?></p>
    <?php else: ?>
      <p>Veículo não encontrado ou não registrado como saído.</p>
    <?php endif; ?>

    <div class="mt-3">
      <a href="registro-saida.php" class="btn btn-secondary">Voltar para Registro de Saída</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
