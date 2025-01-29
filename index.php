<?php
require_once 'app/controllers/ExameController.php';
require_once 'app/controllers/PacienteController.php';
require_once 'app/controllers/VincularExamePacienteController.php';

// Configuração do banco de dados
try {
    $pdo = new PDO('mysql:host=localhost;dbname=worklabweb', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Instancia os controladores com o PDO
$exameController = new ExameController($pdo);
$pacienteController = new PacienteController();

// Tratamento para requisições POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Cadastrar Exame
        if (isset($_POST['cadastrar_exame'])) {
            $dadosExame = [
                'codigo' => $_POST['codigo'],
                'descricao' => $_POST['descricao'],
                'valor' => $_POST['valor']
            ];

            $exameController->cadastrarExame($dadosExame);
            echo "<p>Exame cadastrado com sucesso!</p>";
        }

        // Cadastrar Paciente
        if (isset($_POST['cadastrar_paciente'])) {
            $dadosPaciente = [
                'nome' => $_POST['nome'],
                'sexo' => $_POST['sexo'],
                'email' => $_POST['email'],
                'celular' => $_POST['celular'],
                'exames' => $_POST['codigo_exame'] // Recebe todos os exames selecionados
            ];

            $numeroAtendimento = $pacienteController->cadastrarPaciente($dadosPaciente);
            echo "<p>Paciente cadastrado com sucesso! Número de atendimento: $numeroAtendimento</p>";

            // Vincular exames após cadastro
            if (!empty($_POST['codigo_exame'])) {
                foreach ($_POST['codigo_exame'] as $codigoExame) {
                    $pacienteController->vincularExameAoPaciente($numeroAtendimento, $codigoExame);
                }
            }
        }
    } catch (Exception $e) {
        echo "<p>Erro: " . $e->getMessage() . "</p>";
    }
}

// Recupera os exames cadastrados
$exames = $exameController->listarExames();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Cadastro de Exames e Pacientes</title>
</head>

<body>
    <!-- Formulário de Cadastro de Exames -->
    <form method="POST">
        <h1>Bem Vindo ao LabSys <i class="fas fa-flask"></i></h1>
        <h3>Cadastrar Exame</h3>
        <input type="text" name="codigo" placeholder="Código do Exame" required>
        <input type="text" name="descricao" placeholder="Descrição do Exame" required>
        <input type="number" name="valor" placeholder="Valor do Exame" step="0.01" required>
        <button type="submit" name="cadastrar_exame">Cadastrar Exame</button>
    </form>

    <!-- Formulário de Cadastro de Pacientes -->
    <form method="POST">
        <h3>Cadastrar Paciente</h3>
        <input type="text" name="nome" placeholder="Nome Completo" required>
        <select name="sexo" required>
            <option value="">Selecione o Sexo</option>
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
        </select>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="text" name="celular" placeholder="Celular" required>

        <div id="exames-container">
            <label for="codigo_exame">Selecione os Exames</label>
            <div class="exame">
                <select name="codigo_exame[]" required>
                    <option value="">Selecione o Exame</option>
                    <?php foreach ($exames as $exame): ?>
                        <option value="<?= $exame['codigo'] ?>"><?= $exame['codigo'] ?> - R$ <?= number_format($exame['valor'], 2, ',', '.') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="button" id="add-exame">+ Adicionar Exame</button>
        <button type="submit" name="cadastrar_paciente">Cadastrar Paciente</button>
    </form>

    <script>
        document.getElementById('add-exame').addEventListener('click', function() {
            var exameContainer = document.getElementById('exames-container');
            var newExameSelect = document.createElement('div');
            newExameSelect.classList.add('exame');
            newExameSelect.innerHTML = `
                <select name="codigo_exame[]" required>
                    <option value="">Selecione o Exame</option>
                    <?php foreach ($exames as $exame): ?>
                        <option value="<?= $exame['codigo'] ?>"><?= $exame['codigo'] ?> - R$ <?= number_format($exame['valor'], 2, ',', '.') ?></option>
                    <?php endforeach; ?>
                </select>
            `;
            exameContainer.appendChild(newExameSelect);
        });
    </script>
</body>

</html>