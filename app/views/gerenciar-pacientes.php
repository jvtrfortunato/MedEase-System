<?php
session_start();
require_once '../controller/PacienteController.php';

$controller = new PacienteController();

$termoBusca = $_POST['termo'] ?? '';

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
    <title>Pacientes</title>
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
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/gerenciar-pacientes.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    <main>

        <section class="conteudo-principal">

            <form action="" method="POST" style="display: flex;">
                <section class="busca">
                    <img src="../../assets/img/lupa.png" alt="Lupa de pesquisa">
                    <input type="text" name="termo" placeholder="Buscar Paciente (nome do paciente)" value="<?= htmlspecialchars($_POST['termo'] ?? '') ?>">
                </section>
                <button type="submit" class="btnBusca">Buscar</button>
            </form>
        

            <section class="pacientes">
                
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
                            Ver detalhes
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
            <button class="botaoVerde" onClick="window.location.href = 'cadastrar-paciente.php'">Cadastrar Paciente</button>
        </section>
        
    </main>
    <footer></footer>

    <script>
        //Função para voltar para a home
        const voltarPagina = document.getElementById("voltarPagina");

        const tipoUsuario = "<?php echo $_SESSION['usuario_tipo']; ?>";

        if (voltarPagina) {
            voltarPagina.addEventListener("click", () => {
                if (tipoUsuario === 'administrador') {
                    window.location.href = "home-administrador.php";
                } else {
                    window.location.href = "home-secretario.php";
                }
            });
        }
    </script>
</body>
</html>
