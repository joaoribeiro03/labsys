<?php
require_once './config/config.php';

class VincularExamePacienteController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Busca o ID do paciente com base no numero_atendimento
    public function obterPacienteId($numeroAtendimento)
    {
        $sql = "SELECT id FROM pacientes WHERE numero_atendimento = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$numeroAtendimento]);
        $pacienteId = $stmt->fetchColumn();

        if (!$pacienteId) {
            throw new Exception("Paciente não encontrado!");
        }

        return $pacienteId;
    }

    // Busca o ID do exame com base no código do exame
    public function obterExameId($codigoExame)
    {
        $sql = "SELECT id FROM exames WHERE codigo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codigoExame]);
        $exameId = $stmt->fetchColumn();

        if (!$exameId) {
            throw new Exception("Exame não encontrado!");
        }

        return $exameId;
    }

    // Vincula o paciente ao exame, garantindo que não haja duplicados
    public function vincularExameAoPaciente($numeroAtendimento, $codigoExame)
    {
        // Obter os IDs do paciente e do exame
        $paciente = new Paciente();
        $pacienteId = $paciente->obterIdPorNumeroAtendimento($numeroAtendimento);
    
        $exame = new Exame(); // Supondo que você tenha uma classe Exame que lida com os exames
        $exameId = $exame->obterIdPorCodigo($codigoExame);
    
        if ($pacienteId && $exameId) {
            // Cria uma instância do modelo para realizar a vinculação
            $vincular = new VincularExamePaciente();
    
            // Chama o método para vincular o exame ao paciente
            $vincular->vincular($pacienteId, $exameId);
        }
    }
    
}