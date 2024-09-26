<?php
require_once 'config/connect.php'; // Inclui a conexão com o banco de dados

try {
    // Consulta para obter todos os veículos e suas informações
    $sql = "SELECT V.PLACA, V.ENTRADA, V.SAIDA, V.TEMPO, V.VALOR, T.TIPO 
            FROM VEICULOS V
            JOIN TIPO_VEICULO T ON V.VEI_TIPO = T.ID
            WHERE V.SAIDA IS NOT NULL"; // Somente veículos com saída registrada
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcular totais
    $total_veiculos = count($veiculos);
    $total_revenue = 0;
    $total_carros = 0;
    $total_caminhonetes = 0;
    $total_motos = 0;

    foreach ($veiculos as $veiculo) {
        $total_revenue += $veiculo['VALOR'];

        // Contagem por tipo de veículo
        switch ($veiculo['TIPO']) {
            case 'Carro':
                $total_carros++;
                break;
            case 'Caminhonete':
                $total_caminhonetes++;
                break;
            case 'Moto':
                $total_motos++;
                break;
        }
    }
} catch (PDOException $e) {
    die("Erro ao buscar veículos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ParkPlus - Administração</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div id="topo">
    <?php include "partes/topo.php"?>
  </div>
  <div id="menu">
    <?php include "partes/menu.php"?>
  </div>

  <div class="container mt-5">
    <h2 class="text-center">ParkPlus - Administração</h2>
    
    <div class="mt-5">
      <h4>Gerenciamento de Veículos</h4>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Placa do Veículo</th>
            <th>Tipo de Veículo</th>
            <th>Hora de Entrada</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="vehicle-management">
          <?php if ($total_veiculos > 0): ?>
            <?php foreach ($veiculos as $veiculo): ?>
              <tr>
                <td><?= htmlspecialchars($veiculo['PLACA']); ?></td>
                <td><?= htmlspecialchars($veiculo['TIPO']); ?></td>
                <td><?= htmlspecialchars($veiculo['ENTRADA']); ?></td>
                <td>
                  <a href="detalhes-veiculo.php?placa=<?= urlencode($veiculo['PLACA']); ?>" class="btn btn-sm btn-info">Ver Detalhes</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center">Nenhum veículo registrado.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="mt-5">
      <h4>Relatórios</h4>
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Total de Veículos</h5>
              <p class="card-text" id="total-vehicles"><?= $total_veiculos; ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Veículos por Tipo</h5>
              <p class="card-text">
                Carro de Passeio: <span id="total-carros"><?= $total_carros; ?></span><br>
                Caminhonete: <span id="total-caminhonetes"><?= $total_caminhonetes; ?></span><br>
                Moto: <span id="total-motos"><?= $total_motos; ?></span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Receita Gerada</h5>
              <p class="card-text">R$ <span id="total-revenue"><?= number_format($total_revenue, 2, ',', '.'); ?></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5">
      <a href="veiculo.php" class="btn btn-secondary">Cadastro de Veículos</a>
      <a href="registro-saida.php" class="btn btn-secondary">Registro de Saída</a>
    </div>
  </div>
  <div id="rodape">
    <?php include "partes/rodape.php"?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>
</html>
