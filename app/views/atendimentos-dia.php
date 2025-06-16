<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atendimentos do dia</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/atendimentos-dia.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
</head>
<body>

    <?php
        require_once '../controller/ConsultaController.php';
        require_once '../routers/roteadorConsulta.php';

        if (!isset($_SESSION['usuario_id']) || 
            ($_SESSION['usuario_tipo'] !== 'medico' && $_SESSION['usuario_tipo'] !== 'administrador')) {
            header("Location: login.php");
            exit;
        }

        if ($_SESSION['usuario_tipo'] == 'medico') {
            $id_medico = $_SESSION['medico_id'];
            $controller = new ConsultaController();
            $consultas = $controller->listarConsultasDoDia($id_medico);
        }

        if ($_SESSION['usuario_tipo'] == 'administrador') {
            $controller = new ConsultaController();
            $consultas = $controller->listarTodasConsultasDoDia();
        }

        date_default_timezone_set('America/Sao_Paulo');

        $dataHoje = date('d-m-Y');
        $_SESSION['data_hoje'] = $dataHoje;

        $dataCriacao = date('Y-m-d');
        $_SESSION['data_criacao'] = $dataCriacao;

    ?>

    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    <main>
        <section class="conteudo-principal">
            <!-- ATENDIMENTOS PENDENTES -->
            <h1>Atendimentos pendentes - <?php echo $dataHoje; ?></h1>
            <div class="legenda">                             
                <p class="paciente-legenda">Paciente</p>               
                <div class="horario-status">
                    <p class="horario-legenda">Horário</p>
                    <p class="status-legenda">Status</p>
                </div>
            </div>           
            <section class="consultas">
                <?php foreach ($consultas['pendentes'] as $item): ?>
                    <?php $consulta = $item['consulta']; ?>
                    <div class="paciente">
                        <div class="nome">
                            <p><?php echo htmlspecialchars($item['nome_paciente']); ?></p>
                        </div>

                        <div class="hora-status">
                            <div class="horario">
                                <p><?php echo date('H:i', strtotime($consulta->getDataInicio())); ?></p>
                            </div>
                            <div class="status">
                                <p><?php echo htmlspecialchars($consulta->getStatus()); ?></p>
                                <a href="../routers/roteadorConsulta.php?acao=iniciarConsulta&consulta_id=<?php echo $consulta->getId(); ?>" class="iniciar-consulta">Iniciar Consulta</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

            <!-- ATENDIMENTOS REALIZADOS -->
            <h1 class="atendimentos-finalizados-titulo">Atendimentos realizados - <?php echo $dataHoje; ?></h1>
            <div class="legenda">                              
                <p class="paciente-legenda">Paciente</p>               
                <div class="horario-status">
                    <p class="horario-legenda">Horário</p>
                    <p class="status-legenda">Status</p>
                </div>
            </div>
            <section class="consultas">
                <?php foreach ($consultas['realizadas'] as $item): ?>
                    <?php $consulta = $item['consulta']; ?>
                    <div class="paciente">
                        <div class="nome">
                            <p><?php echo htmlspecialchars($item['nome_paciente']); ?></p>
                        </div>

                        <div class="hora-status">
                            <div class="horario">
                                <p><?php echo date('H:i', strtotime($consulta->getDataInicio())); ?></p>
                            </div>
                            <div class="status">
                                <p><?php echo htmlspecialchars($consulta->getStatus()); ?></p>
                                <a href="editar-prontuario.php?consulta_id=<?php echo $consulta->getId(); ?>" class="editar-prontuario">Editar Prontuário</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </section>
        <section class="botoes">
            <button class="voltar" type="button" id="voltarPagina">Voltar</button>
        </section>
    </main>
    <footer></footer>

    <script>
        //Função para voltar para a home
        const voltarPagina = document.getElementById("voltarPagina"); // Certifique-se de que existe esse elemento

        const tipoUsuario = "<?php echo $_SESSION['usuario_tipo']; ?>"; // Exemplo usando sessão

        if (voltarPagina) {
            voltarPagina.addEventListener("click", () => {
                console.log(tipoUsuario);

                if (tipoUsuario === 'administrador') {
                    window.location.href = "home-administrador.php";
                } 
                
                if (tipoUsuario === 'medico') {
                    window.location.href = "home-medico.php";
                }
                
                if (tipoUsuario === 'secretario') {
                    window.location.href = "home-secretario.php";
                }
            });
        }
    </script>

</body>
</html>