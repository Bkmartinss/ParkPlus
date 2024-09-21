<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ParkPlus - Administração</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
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
          <!-- Os registros de veículos serão inseridos aqui -->
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
              <p class="card-text" id="total-vehicles">0</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Veículos por Tipo</h5>
              <p class="card-text">
                Carro de Passeio: <span id="total-carros">0</span><br>
                Caminhonete: <span id="total-caminhonetes">0</span><br>
                Moto: <span id="total-motos">0</span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Receita Gerada</h5>
              <p class="card-text">R$ <span id="total-revenue">0,00</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5">
      <a href="index.php" class="btn btn-secondary">Cadastro de Veículos</a>
      <a href="registro-saida.php" class="btn btn-secondary">Registro de Saída</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>
</html>