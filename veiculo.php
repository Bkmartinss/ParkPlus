<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Veículos - ParkPlus</title>
  <!-- Fonte do google - Topo -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div id="topo">
    <?php include "partes/topo.php" ?>
  </div>
  <div id="menu">
    <?php include "partes/menu.php" ?>
  </div>

  <div class="container mt-5">
    <h2 class="text-center">ParkPlus - Cadastro de Veículos</h2>

    <div class="d-flex justify-content-center mt-4">
      <a href="registro-saida.php" class="btn btn-secondary mx-2">Registrar Saída</a>
      <a href="administracao.php" class="btn btn-secondary mx-2">Administração</a>
    </div>

    <form id="vehicle-form" class="mt-4">
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

    <div id="message" class="alert mt-3" style="display: none;"></div>
  </div>

  <div id="rodape">
    <?php include "partes/rodape.php" ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#vehicle-form').on('submit', function (event) {
        event.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
          type: 'POST',
          url: 'actions/cadastrar.php',
          data: formData,
          success: function (response) {
            $('#message').removeClass('alert-danger alert-warning alert-success').html(response).fadeIn();

            if (response.includes('sucesso')) {
              $('#message').addClass('alert-success');
              $('#vehicle-form')[0].reset();
            } else if (response.includes('Erro ao cadastrar')) {
              $('#message').addClass('alert-danger');
            } else {
              $('#message').addClass('alert-warning');
            }
          },
          error: function () {
            $('#message').removeClass('alert-success alert-warning').addClass('alert-danger').html('Erro na requisição. Tente novamente mais tarde.').fadeIn();
          }
        });
      });
    });
  </script>
</body>
</html>
