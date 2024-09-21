<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Veículos - ParkPlus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center">ParkPlus - Cadastro de Veículos</h2>

    <div class="d-flex justify-content-center mt-4">
      <a href="registro-saida.php" class="btn btn-secondary mx-2">Registrar Saída</a>
      <a href="administracao.php" class="btn btn-secondary mx-2">Administração</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
      <div class="alert alert-<?php echo htmlspecialchars($_GET['type']); ?>">
        <?php echo htmlspecialchars($_GET['msg']); ?>
      </div>
    <?php endif; ?>

    <form id="vehicle-form" class="mt-4" method="POST" action="actions/cadastrar.php">
  <div class="mb-3">
    <label for="plate" class="form-label">Placa do Veículo</label>
    <input type="text" class="form-control" id="plate" name="plate" placeholder="Digite a placa" required>
  </div>
  <div class="mb-3">
    <label for="vehicle-type" class="form-label">Tipo de Veículo</label>
    <select class="form-select" id="vehicle-type" name="vehicle-type" required>
      <option value="" selected disabled>Selecione o tipo</option>
      <option value="1">Moto</option>
      <option value="2">Carro de Passeio</option>
      <option value="3">Caminhonete</option>
    </select>
  </div>
  <div class="mb-3">
    <label for="entry-time" class="form-label">Hora de Entrada</label>
    <input type="time" class="form-control" id="entry-time" name="entry-time" required>
  </div>
  <button type="submit" class="btn btn-primary">Cadastrar Veículo</button>
</form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>