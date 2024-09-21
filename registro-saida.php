<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ParkPlus - Registro de Saída</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center">ParkPlus - Registro de Saída</h2>
    
    <form id="exit-form">
      <div class="mb-3">
        <label for="plate-exit" class="form-label">Placa do Veículo</label>
        <input type="text" class="form-control" id="plate-exit" placeholder="Digite a placa" required>
      </div>
      <div class="mb-3">
        <label for="exit-time" class="form-label">Hora de Saída</label>
        <input type="time" class="form-control" id="exit-time" required>
      </div>
      <div class="mb-3">
        <label for="vehicle-type-exit" class="form-label">Tipo de Veículo</label>
        <select class="form-select" id="vehicle-type-exit" required>
          <option value="" selected disabled>Selecione o tipo</option>
          <option value="Carro de Passeio">Carro de Passeio</option>
          <option value="Caminhonete">Caminhonete</option>
          <option value="Moto">Moto</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="tariff" class="form-label">Tarifa Calculada</label>
        <input type="text" class="form-control" id="tariff" readonly>
      </div>
      <button type="submit" class="btn btn-primary">Registrar Saída</button>
    </form>   
    <div class="mt-3">
      <a href="index.php" class="btn btn-secondary">Voltar para Cadastro de Veículos</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>
</html>