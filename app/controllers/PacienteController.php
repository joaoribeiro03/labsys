<?php
require_once __DIR__ . '/../models/Paciente.php';

class PacienteController
{
    /**
     * Processa o cadastro de um paciente.
     *
     * @param array $dados Array associativo com os dados do paciente.
     * @return int Retorna o número de atendimento gerado.
     * @throws Exception Caso algum campo obrigatório esteja ausente ou o cadastro falhe.
     */
    public function cadastrarPaciente(array $dados)
    {
        if (empty($dados['nome']) || empty($dados['sexo']) || empty($dados['email']) || empty($dados['celular'])) {
            throw new Exception("Todos os campos são obrigatórios!");
        }

        $paciente = new Paciente();

        $paciente->setNomeCompleto($dados['nome']);
        $paciente->setSexo($dados['sexo']);
        $paciente->setEmail($dados['email']);
        $paciente->setCelular($dados['celular']);

        return $paciente->cadastrar();
    }

    public function listarPacientes()
    {
        $paciente = new Paciente();

        return $paciente->listarTodos();
    }

    public function vincularExameAoPaciente($numeroAtendimento, $codigoExame)
    {
        // Obter os IDs do paciente e do exame
        $paciente = new Paciente();
        $pacienteId = $paciente->obterIdPorNumeroAtendimento($numeroAtendimento);

        if (!$pacienteId) {
            throw new Exception("Paciente não encontrado.");
        }

        $exame = new Exame(); // Supondo que você tenha uma classe Exame que lida com os exames
        $exameId = $exame->obterIdPorCodigo($codigoExame);

        if (!$exameId) {
            throw new Exception("Exame não encontrado.");
        }

        // Cria uma instância do modelo para realizar a vinculação
        $vincular = new VincularExamePaciente();

        // Chama o método para vincular o exame ao paciente
        $vincular->vincular($pacienteId, $exameId);
    }
}
