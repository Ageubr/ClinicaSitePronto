<?php
include('db.php'); // Inclui a função de conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar ao banco de dados de usuários
    $pdo = conectarBanco('UsuariosDB');

    // Captura e sanitiza os dados do formulário
    $nome_completo = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'regUsername', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'regPassword', FILTER_SANITIZE_STRING);

    // Verifica se o CPF ou nome de usuário já estão cadastrados
    $sql = "SELECT * FROM usuarios WHERE cpf = :cpf OR username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "CPF ou nome de usuário já registrados!";
    } else {
        // Criptografa a senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Insere os dados do novo usuário no banco de dados
        $sql = "INSERT INTO usuarios (nome_completo, cpf, username, senha) VALUES (:nome_completo, :cpf, :username, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_completo', $nome_completo);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':senha', $senha_hash);

        if ($stmt->execute()) {
            // Redireciona para a página de login após o cadastro bem-sucedido
            header("Location: login.php");
            exit();
        } else {
            echo "Erro ao registrar o usuário.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../Clinica Otorrinolaringologia/styles.css">
</head>
<body>
    <h1>Cadastro de Usuário</h1>
    <form id="registerForm" action="registrar.php" method="POST">
        <input type="text" id="fullName" name="fullName" placeholder="Nome Completo" required>
        <input type="text" id="cpf" name="cpf" placeholder="CPF" required>
        <input type="text" id="regUsername" name="regUsername" placeholder="Nome de Usuário" required>
        <input type="password" id="regPassword" name="regPassword" placeholder="Senha" required>
        <button type="submit">Registrar</button>
    </form>
    <a href="../Clinica Otorrinolaringologia/pages/index.html">Voltar para a Página Inicial</a>
    <script src="../script.js"></script>
</body>
</html>
