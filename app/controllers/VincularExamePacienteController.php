<?php
require_once './config/config.php';

class VincularExamePacienteController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function vincularExameAoPaciente($numeroAtendimento, $codigoExame)
    {
        $pacienteId = $this->obterPacienteId($numeroAtendimento);
        $exameId = $this->obterExameId($codigoExame);

        if ($pacienteId && $exameId) {
            $sql = "INSERT INTO paciente_exames (paciente_id, exame_id) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$pacienteId, $exameId]);
            echo "Exame vinculado ao paciente com sucesso!";
        } else {
            echo "Falha ao vincular exame. Verifique os dados.";
        }
    }

    private function obterPacienteId($numeroAtendimento)
    {
        $sql = "SELECT id FROM pacientes WHERE numero_atendimento = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$numeroAtendimento]);
        return $stmt->fetchColumn();
    }

    private function obterExameId($codigoExame)
    {
        $sql = "SELECT id FROM exames WHERE codigo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codigoExame]);
        return $stmt->fetchColumn();
    }
}
?>
