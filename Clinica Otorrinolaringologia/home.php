<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
$usuario_nome = isset($_SESSION['usuario_nome']) ? $_SESSION['usuario_nome'] : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Clínica Otoh</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <header>
        <img src="./images/logo.png" alt="Logo da Página" class="logo">
        <nav>
            <ul>
                <li><a href="./pages/treatments.html">Tratamentos</a></li>
                <li><a href="./pages/doctors.html">Médicos</a></li>
                <li><a href="./pages/contact.html">Contato</a></li>
                <li><a href="./agendar_consulta.php">Consultas</a></li>
                <li><a href="./consulta_handler.php">Agendamentos</a></li>
            </ul>
        </nav>
        
        <!-- Exibe o botão de login ou boas-vindas dependendo do estado da sessão -->
        <div class="auth-buttons">
            <?php if ($usuario_nome): ?>
                <span>Bem-vindo, <?php echo htmlspecialchars($usuario_nome); ?>!</span>
                <a href="logout.php" class="btn">Sair</a> <!-- Botão de logout -->
            <?php else: ?>
                <a href="./login.php" class="btn">Login</a>
                <a href="./registrar.php" class="btn">Registro</a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <section id="about">
            <h2>Bem-vindo à nossa clínica</h2>
            <p>A Clínica Otoh é especializada em otorrinolaringologia e foi fundada em 2010, localizada em Taguatinga Sul, Brasília-DF. Nossa missão é oferecer tratamentos de alta qualidade para uma variedade de condições relacionadas a ouvido, nariz e garganta.</p>
        </section>

        <section id="presentation-video">
            <video width="100%" controls>
                <source src="../Clinica Otorrinolaringologia/videos/apresentacao.mp4" type="video/mp4">
                Seu navegador não suporta a reprodução de vídeos.
            </video>   
        </section>
        
        <section id="treatments">
            <h2>Tratamentos Disponíveis</h2>
            <div class="treatment">
                <h3>Amigdalite</h3>
                <p>Tratamos a amigdalite com opções que vão desde medicamentos até cirurgias, conforme a necessidade.</p>
            </div>
            <div class="treatment">
                <h3>Apneia do Sono</h3>
                <p>Oferecemos diagnósticos e tratamentos personalizados para apneia do sono, visando melhorar a qualidade do seu sono.</p>
            </div>
            <div class="treatment">
                <h3>Distúrbio do Labirinto</h3>
                <p>Nossos especialistas avaliam e tratam distúrbios do labirinto para ajudar no equilíbrio e na audição.</p>
            </div>
            <div class="treatment">
                <h3>Faringite</h3>
                <p>Fornecemos cuidados adequados para a faringite, com diagnósticos precisos e opções de tratamento.</p>
            </div>
            <div class="treatment">
                <h3>Otite</h3>
                <p>Tratamos infecções de ouvido, oferecendo cuidados especializados e orientações para prevenção.</p>
            </div>
            <div class="treatment">
                <h3>Perda Auditiva</h3>
                <p>Realizamos avaliações auditivas e sugerimos opções de tratamento adequadas, incluindo aparelhos auditivos.</p>
            </div>
            <div class="treatment">
                <h3>Rinite</h3>
                <p>Oferecemos diagnósticos e tratamentos para rinite, ajudando a aliviar os sintomas.</p>
            </div>
            <div class="treatment">
                <h3>Sinusite</h3>
                <p>Tratamos a sinusite com uma abordagem completa para garantir alívio e recuperação.</p>
            </div>
        </section>

        <section id="actions">
            <h2>Agende uma consulta agora mesmo!</h2>
            <a href="./agendar_consulta.php" class="btn">Agendamento de consultas</a>
        </section>
    </main>

    <footer>
        <p>© 2024 Clínica Otoh. Todos os direitos reservados.</p>
    </footer>

    <script src="../script.js"></script>
</body>
</html>
