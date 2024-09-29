<?php
require_once '../config/connect.php'; // Inclui a conexão com o banco de dados

if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];

    // Aqui você deve buscar os dados do veículo com a placa informada e exibir um formulário para edição
    try {
        $sql = "SELECT * FROM VEICULOS WHERE PLACA = :placa";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['placa' => $placa]);
        $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$veiculo) {
            die("Veículo não encontrado.");
        }
    } catch (PDOException $e) {
        die("Erro ao buscar veículo: " . $e->getMessage());
    }
} else {
    die("Placa do veículo não informada.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Veículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Veículo</h2>
        <form action="../actions/update.php" method="post">
            <input type="hidden" name="placa" value="<?= htmlspecialchars($veiculo['PLACA']); ?>">
            
            <div class="mb-3">
                <label for="entrada" class="form-label">Hora de Entrada</label>
                <input type="text" class="form-control" id="entrada" name="entrada" value="<?= htmlspecialchars($veiculo['ENTRADA']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="saida" class="form-label">Hora de Saída</label>
                <input type="text" class="form-control" id="saida" name="saida" value="<?= htmlspecialchars($veiculo['SAIDA']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" class="form-control" id="valor" name="valor" value="<?= htmlspecialchars($veiculo['VALOR']); ?>" step="0.01" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="../administracao.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
