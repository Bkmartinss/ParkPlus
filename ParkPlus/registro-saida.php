<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParkPlus - Registro de Saída</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div id="topo">
        <?php include "partes/topo.php"; ?>
    </div>
    <div id="menu">
        <?php include "partes/menu.php"; ?>
    </div>

    <div class="container mt-5">
        <h2 class="text-center">ParkPlus - Registro de Saída</h2>

        <div id="message" class="alert fade show" style="display: none;"></div>

        <form id="exit-form">
            <div class="mb-3">
                <label for="plate-exit" class="form-label">Placa do Veículo</label>
                <select class="form-select" id="plate-exit" name="plate_exit" required>
                    <option value="" selected disabled>Carregando placas...</option>
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

        <div class="mt-5">
            <h3>Veículos Estacionados</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Hora de Entrada</th>
                        <th>Tipo de Veículo</th>
                    </tr>
                </thead>
                <tbody id="parked-vehicles">
                </tbody>
            </table>
        </div>
    </div>

    <div id="rodape">
        <?php include "partes/rodape.php"; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        $.ajax({
            url: 'actions/get_plates.php',
            type: 'GET',
            success: function (response) {
                var veiculos = response;
                var plateSelect = $('#plate-exit');
                plateSelect.empty();
                plateSelect.append('<option value="" selected disabled>Selecione a placa...</option>');

                veiculos.forEach(function (veiculo) {
                    plateSelect.append(
                        `<option value="${veiculo.PLACA}">${veiculo.PLACA}</option>`
                    );
                });
            },
            error: function () {
                $('#message').html("<div class='alert alert-danger'>Erro ao carregar as placas dos veículos.</div>").fadeIn();
            }
        });

        $('#exit-form').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'actions/registrar-saida.php',
                data: formData,
                success: function (response) {
                    $('#message').removeClass('alert-danger alert-warning alert-success').fadeIn().html(response);

                    if (response.includes('sucesso')) {
                        $('#message').addClass('alert-success');
                        $('#exit-form')[0].reset();
                        loadParkedVehicles();

                        setTimeout(function() {
                            location.reload();
                        }, 5000);
                    } else if (response.includes('Erro ao registrar')) {
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

        function loadParkedVehicles() {
            $.ajax({
                url: 'actions/get_parked_vehicles.php',
                type: 'GET',
                success: function (response) {
                    var parkedVehicles = response;
                    var parkedVehiclesTable = $('#parked-vehicles');
                    parkedVehiclesTable.empty();

                    parkedVehicles.forEach(function (veiculo) {
                        parkedVehiclesTable.append(`
                            <tr>
                                <td>${veiculo.PLACA}</td>
                                <td>${veiculo.ENTRADA}</td>
                                <td>${veiculo.VEI_TIPO}</td>
                            </tr>
                        `);
                    });
                },
                error: function () {
                    $('#message').html("<div class='alert alert-danger'>Erro ao carregar veículos estacionados.</div>").fadeIn();
                }
            });
        }

        loadParkedVehicles();
    });
</script>
</body>
</html>