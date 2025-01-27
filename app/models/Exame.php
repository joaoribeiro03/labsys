<?php
require_once './config/config.php';
class Exame
{
    private $pdo;
    private $codigo;
    private $descricao;
    private $valor;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function cadastrar()
    {
        $sql = "SELECT COUNT(*) FROM exames WHERE codigo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->codigo]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            throw new Exception("Exame com código {$this->codigo} já existe!");
        }

        $sql = "INSERT INTO exames (codigo, descricao, valor) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->codigo, $this->descricao, $this->valor]);
    }
}
