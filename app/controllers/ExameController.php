<?php
require_once __DIR__ . '/../models/Exame.php';

class ExameController
{
    private $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function cadastrarExame($dadosExame)
    {
        $codigo = $dadosExame['codigo'] ?? null;
        $descricao = $dadosExame['descricao'] ?? null;
        $valor = $dadosExame['valor'] ?? null;

        if (empty($codigo) || empty($descricao) || !is_numeric($valor)) {
            throw new Exception("Todos os campos são obrigatórios e o valor deve ser numérico.");
        }

        $codigo = htmlspecialchars(strip_tags($codigo));
        $descricao = htmlspecialchars(strip_tags($descricao));
        $valor = floatval($valor);

        $sql = "INSERT INTO exames (codigo, descricao, valor) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute([$codigo, $descricao, $valor])) {
            echo "<script>window.onload = function() { alert('Exame cadastrado com sucesso!'); }</script>";
        } else {
            echo "<script>window.onload = function() { alert('Erro ao cadastrar o exame. Tente novamente.'); }</script>";
        }
    }

    public function listarExames()
    {
        $sql = "SELECT * FROM exames";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
