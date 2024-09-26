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
                        const entrada = new Date(`1970-01-01T${data.horaEntrada}`);
                        const saida = new Date(`1970-01-01T${exitTime}`);

                       
                        const tempoPermanencia = Math.ceil((saida - entrada) / (1000 * 60 * 60)); // em horas

                        
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

                        let valorTotal = tarifaInicial;
                        if (tempoPermanencia > 1) {
                            valorTotal += (tempoPermanencia - 1) * tarifaAdicional;
                        }

                        tariffInput.value = `R$ ${valorTotal.toFixed(2)}`;

                        
                        generateReceipt(data, tempoPermanencia, valorTotal);
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

    function generateReceipt(data, tempoPermanencia, valorTotal) {
        const receipt = `
            Recibo de Saída
            Placa: ${data.placa}
            Tipo: ${data.tipoVeiculo}
            Tempo de Permanência: ${tempoPermanencia} hora(s)
            Valor Total: R$ ${valorTotal.toFixed(2)}
        `;
        console.log(receipt); 
    }

    plateSelect.addEventListener("change", function() {
        exitTimeInput.value = ''; 
        tariffInput.value = ''; 
    });

    exitTimeInput.addEventListener("input", calculateTariff);

    loadPlates();
});
