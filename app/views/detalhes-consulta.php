<?php
require_once '../config/Database.php';

$db = new Database();
$pdo = $db->conectar();

// Buscar pacientes
$sqlPacientes = $pdo->query("SELECT id_paciente, nome, cpf FROM pacientes ORDER BY nome");
$pacientes = $sqlPacientes->fetchAll(PDO::FETCH_ASSOC);

// Buscar médicos
$sqlMedicos = $pdo->query("
    SELECT medicos.id_medico AS id_medico, usuarios.nome AS nome, medicos.especialidade AS especialidade
    FROM medicos
    INNER JOIN usuarios ON medicos.id_usuario = usuarios.id_usuario
    ORDER BY usuarios.nome
");
$medicos = $sqlMedicos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Consulta</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/detalhes-consulta.css">
    <script src="../../assets/script/detalhes-consulta.js" defer></script>
    <script src="../../assets/script/mascaraHORA.js" defer></script>
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    
    <main>
        <section class="conteudo-principal">
            <h1>Descrição da Consulta</h1>
            <form action="../routers/roteadorConsulta.php" method="post">
                <input type="hidden" name="acao" value="salvarConsulta">
                <section class="dados-consulta">

                    <div class="linha">
                        <div class="label-input">
                            <label for="motivo">Motivo</label>
                            <input type="text" name="motivo" require>
                        </div>
                        <div class="linha-pequenos">
                            <div class="label-input">
                                <label for="data">Data</label>
                                <input type="date" name="data" require>
                            </div>
                            <div class="label-input">
                                <label for="hora">Hora</label>
                                <input type="text" name="hora" class="hora" require>
                            </div>
                        </div>
                    </div>

                    <div class="linha">
                        <div class="label-input">
                            <!-- Nome do paciente -->
                            <label for="id_paciente">Paciente</label>
                            <select name="id_paciente" required>
                                <option value="">Selecione</option>
                                <?php foreach ($pacientes as $paciente): ?>
                                    <option value="<?= $paciente['id_paciente'] ?>">
                                        <?= htmlspecialchars($paciente['nome']) ?> - CPF: <?= htmlspecialchars($paciente['cpf']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="label-input">
                            <!-- Médico -->
                            <label for="id_medico">Médico</label>
                            <select name="id_medico" required>
                                <option value="">Selecione</option>
                                <?php foreach ($medicos as $medico): ?>
                                    <option value="<?= $medico['id_medico'] ?>">
                                        <?= htmlspecialchars($medico['nome']) ?> - <?= htmlspecialchars($medico['especialidade']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </section>               
                <div class="botoes">
                    <button id="voltarPagina"class="voltar">Voltar</button>
                    <button id="confirmar-consulta" class="salvar" type="submit">Agendar</button>
                </div>
            </form>
        </section>
    </main>
    
    <footer></footer>
</body>
</html>