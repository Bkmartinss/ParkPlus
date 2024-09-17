// Função para salvar os veículos no localStorage
function saveVehicle(plate, vehicleType, entryTime) {
  const vehicles = JSON.parse(localStorage.getItem('vehicles')) || [];
  vehicles.push({ plate, vehicleType, entryTime });
  localStorage.setItem('vehicles', JSON.stringify(vehicles));
}

// Função para obter os veículos do localStorage
function getVehicles() {
  return JSON.parse(localStorage.getItem('vehicles')) || [];
}

// Função para calcular a tarifa
function calculateTariff(vehicleType, duration) {
  const [hours, minutes] = duration.split(':').map(Number);
  const totalHours = hours + (minutes > 0 ? 1 : 0); // Conta frações como horas completas
  
  switch (vehicleType) {
    case 'Carro de Passeio':
      return totalHours <= 1 ? 4.00 : 4.00 + (totalHours - 1) * 2.00;
    case 'Moto':
      return totalHours <= 1 ? 2.00 : 2.00 + (totalHours - 1) * 2.00;
    case 'Caminhonete':
      return totalHours <= 1 ? 6.00 : 6.00 + (totalHours - 1) * 2.00;
    default:
      return 0.00;
  }
}

// Cadastro de veículos
document.getElementById('vehicle-form')?.addEventListener('submit', function (event) {
  event.preventDefault(); // Impede o envio do formulário para evitar recarregar a página

  // Captura os valores do formulário
  const plate = document.getElementById('plate').value;
  const vehicleType = document.getElementById('vehicle-type').value;
  const entryTime = document.getElementById('entry-time').value;

  // Verifica se todos os campos foram preenchidos
  if (plate && vehicleType && entryTime) {
    // Salva o veículo no localStorage
    saveVehicle(plate, vehicleType, entryTime);

    // Cria um novo item de veículo
    const vehicleItem = `
      <li class="list-group-item">
        <strong>Placa:</strong> ${plate} | 
        <strong>Tipo:</strong> ${vehicleType} | 
        <strong>Hora de Entrada:</strong> ${entryTime}
      </li>
    `;

    // Adiciona o novo veículo à lista de veículos cadastrados
    document.getElementById('vehicle-list')?.insertAdjacentHTML('beforeend', vehicleItem);

    // Limpa os campos do formulário
    document.getElementById('vehicle-form')?.reset();
  }
});

// Registro de saída
document.getElementById('exit-form')?.addEventListener('submit', function (event) {
  event.preventDefault(); // Impede o envio do formulário para evitar recarregar a página

  // Captura os valores do formulário
  const plateExit = document.getElementById('plate-exit').value;
  const exitTime = document.getElementById('exit-time').value;
  const vehicleTypeExit = document.getElementById('vehicle-type-exit').value;

  // Obtém os veículos do localStorage
  const vehicles = getVehicles();
  const vehicle = vehicles.find(v => v.plate === plateExit);

  if (vehicle && exitTime) {
    // Calcula o tempo de permanência
    const entryDate = new Date(`1970-01-01T${vehicle.entryTime}:00`);
    const exitDate = new Date(`1970-01-01T${exitTime}:00`);
    const duration = new Date(exitDate - entryDate);
    const hours = duration.getUTCHours();
    const minutes = duration.getUTCMinutes();
    const durationString = `${hours}:${minutes > 0 ? minutes : '00'}`;
    
    // Calcula a tarifa
    const tariff = calculateTariff(vehicleTypeExit, durationString);

    // Cria um novo item de saída
    const exitItem = `
      <li class="list-group-item">
        <strong>Placa:</strong> ${plateExit} | 
        <strong>Hora de Saída:</strong> ${exitTime} | 
        <strong>Tempo de Permanência:</strong> ${durationString} | 
        <strong>Tarifa:</strong> R$ ${tariff.toFixed(2)}
      </li>
    `;

    // Adiciona o novo item de saída à lista
    document.getElementById('exit-list').insertAdjacentHTML('beforeend', exitItem);

    // Atualiza o campo de tarifa calculada
    document.getElementById('tariff').value = `R$ ${tariff.toFixed(2)}`;

    // Limpa os campos do formulário
    document.getElementById('exit-form').reset();
  }
});

// Preenche a lista de veículos cadastrados na tela de cadastro
window.addEventListener('load', () => {
  const vehicles = getVehicles();
  vehicles.forEach(vehicle => {
    const vehicleItem = `
      <li class="list-group-item">
        <strong>Placa:</strong> ${vehicle.plate} | 
        <strong>Tipo:</strong> ${vehicle.vehicleType} | 
        <strong>Hora de Entrada:</strong> ${vehicle.entryTime}
      </li>
    `;
    document.getElementById('vehicle-list')?.insertAdjacentHTML('beforeend', vehicleItem);
  });
});