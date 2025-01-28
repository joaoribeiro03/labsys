<?php

define('DB_HOST', 'labsysdb.mysql.database.azure.com');
define('DB_NAME', 'labsys');
define('DB_USER', 'joaolucas');
define('DB_PASSWORD', 'AbcA1313$');

// Exemplo de conexão com PDO
try {
    // Incluindo charset=utf8 para garantir a codificação correta
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=3306;charset=utf8", DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conectado ao banco de dados com sucesso!";
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
    // Logar a exceção completa (para ajudar na depuração)
    error_log($e->getMessage());
}

/*define('DB_HOST', 'labsysdb.mysql.database.azure.com');
define('DB_NAME', 'labsys');
define('DB_USER', 'joaolucas');
define('DB_PASSWORD', 'AbcA1313$');

// Exemplo de conexão com PDO
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=3306", DB_USER, DB_PASSWORD);
 //   $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conectado ao banco de dados com sucesso!";
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}*/
?>