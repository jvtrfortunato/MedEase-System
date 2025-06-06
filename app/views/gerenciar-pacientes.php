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
    <title>Pacientes</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/gerenciar-pacientes.css">
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
                        <a href="detalhes-paciente.php?id=<?= $paciente->getIdPaciente() ?>" class="botaoVerde">
                            Detalhes
                        </a>
                        <a href="editar-paciente.php?id=<?= $paciente->getIdPaciente() ?>" class="botaoVerde">
                            Editar
                        </a>
                        <a href="../routers/roteadorPaciente.php?acao=excluirPaciente&paciente_id=<?= $paciente->getIdPaciente() ?>" onclick="return confirm('Deseja excluir este paciente?');" class="botaoVermelho">
                            Excluir
                        </a>
                    </div>
                <?php endforeach; ?>
                
            </section>

        </section>
        <section class="botao">
            <button id="voltarPagina" class="botaoVermelho" type="button">Voltar</button>
        </section>
    </main>
    <footer></footer>

    <script>
        // Evento para o botão "Voltar" (se existir)
        if (voltarPagina) {
            voltarPagina.addEventListener("click", () => {
                if (window.history.length > 1) {
                    window.history.back(); // volta à página anterior no histórico
                } else {
                    // Fallback: redireciona manualmente caso não haja histórico
                    if ($tipoUsuario === 'administrador') {
                        window.location.href = "home-administrador.php";
                    }
                    else {
                        window.location.href = "home-secretario.php";
                    }
                }
            });
        }
    </script>
</body>
</html>
