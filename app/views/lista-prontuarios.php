<?php
require_once '../controller/PacienteController.php';

$controller = new PacienteController();
$pacientes = $controller->listarPacientes();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontuários</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/lista-pacientes.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>
    <main>
        <section class="conteudo-principal">

            <section class="busca">
                <img src="../../assets/img/lupa.png" alt="Lupa de pesquisa">
                <input type="text" placeholder="Buscar Paciente (nome do paciente)">
            </section>

            <section class="pacientes">
                
                <div class="legenda">
                    <p class="nome-legenda">Nome Completo</p>
                    <p>CPF</p>
                </div>
                
                <!--Lista dinãmica de pacientes-->
                <?php foreach ($pacientes as $paciente): ?>
                    <div class="dados">
                        <div class="nome">
                            <p><?= htmlspecialchars($paciente->getNome()) ?></p>
                        </div>
                        <div class="cpf">
                            <p><?= htmlspecialchars($paciente->getCpf()) ?></p>
                        </div>
                        <a href="prontuario.php" class="detalhes">
                            Prontuário
                        </a>
                    </div>
                <?php endforeach; ?>

            </section>

        </section>
        <section class="botao">
            <button class="voltar" onclick="history.back()">Voltar</button>
        </section>
    </main>
    <footer></footer>
</body>
</html>