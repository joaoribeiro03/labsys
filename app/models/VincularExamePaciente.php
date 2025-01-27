<?php
require_once 'config.php';

class VincularExamePaciente
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

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

    public function vincular($pacienteId, $exameId)
    {
        $sql = "INSERT INTO paciente_exames (paciente_id, exame_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$pacienteId, $exameId]);
    }
}
