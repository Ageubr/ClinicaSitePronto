<?php
session_start(); // Inicia a sessão

include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpfLogin'];
    $senha = $_POST['password'];

    // Conecta ao banco de dados 'UsuariosDB'
    $pdo = conectarBanco('UsuariosDB');

    // Consulta o banco de dados para verificar o CPF e a senha
    $sql = "SELECT * FROM usuarios WHERE cpf = :cpf";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($senha, $usuario['senha'])) {
            // Se a senha estiver correta, armazena o nome do usuário na sessão
            $_SESSION['usuario_nome'] = $usuario['nome_completo']; // Armazena o nome do usuário na sessão
            $_SESSION['usuario_id'] = $usuario['id']; // Armazena o ID do usuário na sessão
            header("Location: home.php"); // Redireciona para a página inicial (home.php)
            exit();
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../Clinica Otorrinolaringologia/styles.css">
</head>
<body>
    <h1>Login de Usuário</h1>
    <form id="loginForm" action="login.php" method="POST">
        <input type="text" id="cpfLogin" name="cpfLogin" placeholder="CPF" required>
        <input type="password" id="password" name="password" placeholder="Senha" required>
        <button type="submit">Login</button>
    </form>
    <a href="./home.php">Voltar para a Página Inicial</a>
    <script src="../script.js"></script>
</body>
</html>
