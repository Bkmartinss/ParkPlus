document.addEventListener("DOMContentLoaded", function() {
    const plateSelect = document.getElementById("plate-exit");
    const exitTimeInput = document.getElementById("exit-time");
    const tariffInput = document.getElementById("tariff");

    function loadPlates() {
        fetch('actions/get_plates.php')
            .then(response => response.json())
            .then(data => {
                plateSelect.innerHTML = '<option value="" selected disabled>Selecione a placa</option>';
                data.forEach(veiculo => {
                    const option = document.createElement("option");
                    option.value = veiculo.PLACA;
                    option.textContent = veiculo.PLACA;
                    plateSelect.appendChild(option);
                });
            })
            .catch(error => console.error("Erro ao carregar placas:", error));
    }

    function calculateTariff() {
        const selectedPlate = plateSelect.value;
        const exitTime = exitTimeInput.value;

        if (selectedPlate && exitTime) {
            fetch(`actions/get_vehicle_info.php?plate=${encodeURIComponent(selectedPlate)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const entrada = new Date(data.horaEntrada);
                        const [hours, minutes] = exitTime.split(':').map(Number);
                        const tempoSaida = new Date(entrada);
                        tempoSaida.setHours(tempoSaida.getHours() + hours, tempoSaida.getMinutes() + minutes);

                        const horasPermanencia = Math.ceil((tempoSaida - entrada) / (1000 * 60 * 60));

                        let tarifaInicial = 0;
                        let tarifaAdicional = 0;

                        switch (data.tipoVeiculo) {
                            case 'Carro de Passeio':
                                tarifaInicial = 4.00;
                                tarifaAdicional = 2.00;
                                break;
                            case 'Moto':
                                tarifaInicial = 2.00;
                                tarifaAdicional = 2.00;
                                break;
                            case 'Caminhonete':
                                tarifaInicial = 6.00;
                                tarifaAdicional = 2.00;
                                break;
                        }

                        let valorTotal = tarifaInicial + (horasPermanencia > 1 ? (horasPermanencia - 1) * tarifaAdicional : 0);
                        tariffInput.value = `R$ ${valorTotal.toFixed(2)}`;
                    } else {
                        tariffInput.value = '';
                        console.error(data.message);
                    }
                })
                .catch(error => console.error("Erro ao buscar informações do veículo:", error));
        } else {
            tariffInput.value = '';
        }
    }

    plateSelect.addEventListener("change", function() {
        exitTimeInput.value = ''; // Limpa o campo de hora de saída
        tariffInput.value = ''; // Limpa a tarifa
    });

    exitTimeInput.addEventListener("input", calculateTariff);

    loadPlates();
});
