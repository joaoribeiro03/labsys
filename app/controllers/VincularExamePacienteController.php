<?php
require_once __DIR__ . '/../models/Paciente.php';
require_once __DIR__ . '/../models/Exame.php';

class PacienteExameController
{
    // Métodos que lidam com pacientes e exames
}

class VincularExamePacienteController
{
    private $model;

    public function __construct()
    {
        $this->model = new VincularExamePaciente();
    }

    public function vincularExamePaciente($dados)
    {
        try {
            // Obtém o ID do paciente e do exame
            $pacienteId = $this->model->obterPacienteId($dados['numero_atendimento']);
            $exameId = $this->model->obterExameId($dados['codigo_exame']);

            // Realiza o vínculo
            $this->model->vincular($pacienteId, $exameId);

            echo "Exame vinculado ao paciente com sucesso!";
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}
