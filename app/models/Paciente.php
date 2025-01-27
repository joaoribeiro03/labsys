<?php
require_once './config/config.php';

class Paciente
{
    private $pdo;
    private $numero_atendimento;
    private $nome_completo;
    private $sexo;
    private $email;
    private $celular;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getNumeroAtendimento()
    {
        return $this->numero_atendimento;
    }

    public function setNumeroAtendimento($numero_atendimento)
    {
        $this->numero_atendimento = $numero_atendimento;
    }

    public function getNomeCompleto()
    {
        return $this->nome_completo;
    }

    public function setNomeCompleto($nome_completo)
    {
        $this->nome_completo = $nome_completo;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    /**
     * Cadastra o paciente no banco de dados.
     *
     * @return int Retorna o número de atendimento gerado.
     * @throws Exception Caso ocorra algum erro.
     */
    public function cadastrar()
    {
        try {
            $this->numero_atendimento = rand(100000, 999999); // Gera um número de atendimento

            $sql = "INSERT INTO pacientes (numero_atendimento, nome_completo, sexo, email, celular) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $this->numero_atendimento,
                $this->nome_completo,
                $this->sexo,
                $this->email,
                $this->celular
            ]);

            return $this->numero_atendimento;
        } catch (PDOException $e) {
            throw new Exception("Erro ao cadastrar paciente: " . $e->getMessage());
        }
    }
    public function listarTodos()
    {
        $sql = "SELECT * FROM pacientes";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
