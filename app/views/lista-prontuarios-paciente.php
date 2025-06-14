<?php
require_once '../controller/ProntuarioController.php';

$controller = new ProntuarioController();
$prontuarios = $controller->listarProntuarios($_GET['id_paciente']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontuários do Paciente</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/lista-prontuarios-paciente.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    <main>
        <main>
        <section class="conteudo">

            <section class="busca">
                <img src="../../assets/img/lupa.png" alt="Lupa de pesquisa">
                <input type="text" placeholder="Buscar Paciente (nome do paciente)">
            </section>

            <section class="prontuarios">
                
                <div class="legenda">
                    <p class="nome-legenda">Data de consulta</p>
                    <p>Médico responsável</p>
                </div>
                
                <!--Lista dinãmica de pacientes-->
                <?php foreach ($prontuarios as $prontuario): ?>
                    <div class="dados">
                        <div class="nome">
                            <p><?= htmlspecialchars($prontuario->getDataCriacao()) ?></p>
                        </div>
                        <div class="cpf">
                            <p>Dr(a) <?= htmlspecialchars($prontuario->getNomeMedico()) ?></p>
                        </div>
                        <a href="detalhes-prontuario.php?id_consulta=<?php echo $prontuario->getIdConsulta(); ?>" class="detalhes">
                            Abrir Prontuário
                        </a>
                    </div>
                <?php endforeach; ?>

            </section>

        </section>
        <section class="botao">
            <button class="voltar" onclick="history.back()">Voltar</button>
        </section>
    </main>
    </main>
    <footer></footer>
    <script></script>
</body>
</html>