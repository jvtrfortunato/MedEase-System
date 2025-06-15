<?php
session_start();
require_once '../controller/PacienteController.php';

$controller = new PacienteController();

$termoBusca = $_GET['termo'] ?? '';

if(!empty($termoBusca)){
    $pacientes = $controller->buscarPorNome($termoBusca);        
}
else {
    $pacientes = $controller->listarPacientes();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontuários</title>
    <style>
        .btnBusca {
             padding: 6px 12px;
             margin-left: 6px; 
             background-color: #3498db; 
             color: white; border: none; 
             border-radius: 4px; 
             cursor: pointer;
            }
    </style>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/lista-pacientes.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    <main>
        <section class="conteudo-principal">

            <form action="" method="GET" style="display: flex;">
                <section class="busca">
                    <img src="../../assets/img/lupa.png" alt="Lupa de pesquisa">
                    <input type="text" name="termo" placeholder="Buscar Paciente (nome do paciente)" value="<?= htmlspecialchars($_GET['termo'] ?? '') ?>">
                </section>
                <button type="submit" class="btnBusca">Buscar</button>
            </form>

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
                        <a href="lista-prontuarios-paciente.php?id_paciente=<?php echo $paciente->getIdPaciente(); ?>" class="detalhes">
                            Prontuários
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