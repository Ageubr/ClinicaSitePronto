<?php
/**
 * Função para conectar ao banco de dados PostgreSQL.
 *
 * @param string $dbname Nome do banco de dados para se conectar.
 * @return PDO Objeto PDO para interação com o banco.
 * @throws PDOException Caso ocorra um erro na conexão.
 */
function conectarBanco($dbname) {
    $host = 'localhost';
    $username = 'postgres'; // Usuário do PostgreSQL
    $password = '3561'; // Senha do PostgreSQL

    try {
        // Cria uma conexão PDO com o banco especificado
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Retorna um erro caso não consiga se conectar ao banco
        die("Erro na conexão com o banco de dados $dbname: " . $e->getMessage());
    }
}

// Exemplos de uso:

// Conectar ao banco de usuários
try {
    $pdoUsuarios = conectarBanco('UsuariosDB');
    //echo "Conexão com UsuariosDB bem-sucedida!";
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Conectar ao banco de consultas
try {
    $pdoConsultas = conectarBanco('ConsultasDB');
    //echo "Conexão com ConsultasDB bem-sucedida!";
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
