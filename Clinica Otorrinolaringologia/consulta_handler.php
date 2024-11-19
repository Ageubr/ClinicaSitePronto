<?php
include('db.php');

// Lógica para buscar, atualizar e excluir consultas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = isset($_POST['acao']) ? $_POST['acao'] : '';

    // Buscar consulta por CPF
    if ($acao == 'buscar') {
        $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;

        if (empty($cpf)) {
            $resultado = ['erro' => 'CPF não informado.'];
        } else {
            try {
                $sql = "SELECT * FROM consultas WHERE cpf = :cpf";
                $stmt = $pdoConsultas->prepare($sql);
                $stmt->bindParam(':cpf', $cpf);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $consulta = $stmt->fetch(PDO::FETCH_ASSOC);
                    $resultado = $consulta; // Consulta encontrada
                } else {
                    $resultado = ['erro' => 'Nenhuma consulta encontrada para este CPF.'];
                }
            } catch (PDOException $e) {
                $resultado = ['erro' => 'Erro ao buscar consulta: ' . $e->getMessage()];
            }
        }
    }

    // Atualizar consulta
    if ($acao == 'atualizar') {
        $id = $_POST['id'];
        $novaData = $_POST['novaData'];
        $novoEspecialista = $_POST['especialidade']; // Mudança aqui para pegar especialidade corretamente

        try {
            $sql = "UPDATE consultas SET data_consulta = :novaData, especialidade = :novoEspecialista WHERE id = :id";
            $stmt = $pdoConsultas->prepare($sql);
            $stmt->bindParam(':novaData', $novaData);
            $stmt->bindParam(':novoEspecialista', $novoEspecialista);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $resultado = ['sucesso' => 'Consulta atualizada com sucesso!'];
            } else {
                $resultado = ['erro' => 'Erro ao atualizar a consulta.'];
            }
        } catch (PDOException $e) {
            $resultado = ['erro' => 'Erro ao atualizar consulta: ' . $e->getMessage()];
        }
    }

    // Excluir consulta
    if ($acao == 'excluir') {
        $id = $_POST['id'];

        try {
            $sql = "DELETE FROM consultas WHERE id = :id";
            $stmt = $pdoConsultas->prepare($sql);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $resultado = ['sucesso' => 'Consulta excluída com sucesso!'];
            } else {
                $resultado = ['erro' => 'Erro ao excluir a consulta.'];
            }
        } catch (PDOException $e) {
            $resultado = ['erro' => 'Erro ao excluir consulta: ' . $e->getMessage()];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Verificar Consultas</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <header>
        <img src="./images/logo.png" alt="Logo da Página" class="logo">
        <nav>
            <ul>
                <li><a href="./home.php">Início</a></li>
                <li><a href="./pages/treatments.html">Tratamentos</a></li>
                <li><a href="./pages/doctors.html">Médicos</a></li>
                <li><a href="./pages/contact.html">Contato</a></li>
                <li><a href="./agendar_consulta.php">Consultas</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Verificar Consulta</h2>
        <form method="POST" action="consulta_handler.php">
            <input type="text" name="cpf" id="cpfInput" placeholder="Digite seu CPF" required>
            <button type="submit" name="acao" value="buscar">Verificar</button>
        </form>

        <div id="resultado">
            <?php
            // Exibe os resultados ou erros após a busca
            if (isset($resultado)) {
                if (isset($resultado['erro'])) {
                    echo '<p>' . $resultado['erro'] . '</p>';
                } else {
                    echo '<p><strong>Nome:</strong> ' . (isset($resultado['nome']) ? $resultado['nome'] : 'Não disponível') . '</p>';
                    echo '<p><strong>Data da Consulta:</strong> ' . (isset($resultado['data_consulta']) ? $resultado['data_consulta'] : 'Não disponível') . '</p>';
                    echo '<p><strong>Especialidade:</strong> ' . (isset($resultado['especialidade']) ? $resultado['especialidade'] : 'Não disponível') . '</p>';
                    echo '<p><strong>Forma de Pagamento:</strong> ' . (isset($resultado['pagamento']) ? $resultado['pagamento'] : 'Não disponível') . '</p>';

                    // Verifique se o ID está sendo corretamente atribuído
                    $consultaId = isset($resultado['id']) ? $resultado['id'] : null;

                    // Exibe o formulário de atualização
                    echo '<form method="POST" action="consulta_handler.php">
                            <h3>Atualizar Consulta</h3>
                            <input type="hidden" name="id" value="' . $consultaId . '">
                            <label for="novaData">Nova Data:</label>
                            <input type="date" name="novaData" required>
                            
                            <label for="especialidade">Especialidade:</label>
                            <select id="especialidade" name="especialidade" required>
                                <option value="amigdalite" ' . (isset($resultado['especialidade']) && $resultado['especialidade'] == 'amigdalite' ? 'selected' : '') . '>Amigdalite</option>
                                <option value="apneia" ' . (isset($resultado['especialidade']) && $resultado['especialidade'] == 'apneia' ? 'selected' : '') . '>Apneia do Sono</option>
                                <option value="labirinto" ' . (isset($resultado['especialidade']) && $resultado['especialidade'] == 'labirinto' ? 'selected' : '') . '>Distúrbio do Labirinto</option>
                                <option value="faringite" ' . (isset($resultado['especialidade']) && $resultado['especialidade'] == 'faringite' ? 'selected' : '') . '>Faringite</option>
                                <option value="otite" ' . (isset($resultado['especialidade']) && $resultado['especialidade'] == 'otite' ? 'selected' : '') . '>Otite</option>
                                <option value="perda_auditiva" ' . (isset($resultado['especialidade']) && $resultado['especialidade'] == 'perda_auditiva' ? 'selected' : '') . '>Perda Auditiva</option>
                                <option value="rinite" ' . (isset($resultado['especialidade']) && $resultado['especialidade'] == 'rinite' ? 'selected' : '') . '>Rinite</option>
                                <option value="sinusite" ' . (isset($resultado['especialidade']) && $resultado['especialidade'] == 'sinusite' ? 'selected' : '') . '>Sinusite</option>
                            </select>
                            
                            <button type="submit" name="acao" value="atualizar">Atualizar</button>
                        </form>';

                    // Exibe o formulário de exclusão
                    echo '<form method="POST" action="consulta_handler.php">
                            <h3>Excluir Consulta</h3>
                            <input type="hidden" name="id" value="' . $consultaId . '">
                            <button type="submit" name="acao" value="excluir">Excluir</button>
                        </form>';
                }
            }
            ?>
        </div>
    </main>


</body>
</html>
