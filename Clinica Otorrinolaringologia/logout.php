<?php
session_start(); // Inicia a sessão

// Destrói a sessão e redireciona para o login
session_destroy();
header("Location: login.php"); // Redireciona para a página de login
exit();
?>
