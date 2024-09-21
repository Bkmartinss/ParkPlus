<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ParkPlus - Registro de Saída</title>
  <!-- Fonte do google - Topo -->
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
    <h2 class="text-center">ParkPlus - Registro de Saída</h2>
    
    <form id="exit-form" method="POST" action="registrar-saida.php">
      <div class="mb-3">
        <label for="plate-exit" class="form-label">Placa do Veículo</label>
        <select class="form-select" id="plate-exit" name="plate_exit" required>
          <option value="" selected disabled>Carregando placas...</option>
          <?php foreach ($veiculosList as $veiculo) : ?>
            <option value="<?= htmlspecialchars($veiculo['PLACA']); ?>" data-tipo="<?= htmlspecialchars($veiculo['VEI_TIPO']); ?>">
              <?= htmlspecialchars($veiculo['PLACA']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="exit-time" class="form-label">Hora de Saída</label>
        <input type="time" class="form-control" id="exit-time" name="exit_time" required>
      </div>
      <button type="submit" class="btn btn-primary">Registrar Saída</button>
    </form>
    
    <div class="mt-3">
      <a href="veiculo.php" class="btn btn-secondary">Voltar para Cadastro de Veículos</a>
    </div>
  </div>
  <div id="rodape">
    <?php include "partes/rodape.php"?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>
</html>