<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link href="../../assets/css/index-usuarios.css" rel="stylesheet">
    <title>Médico</title>
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>
    
    <main>
        <?php
        session_start();
        $nomeUsuario = $_SESSION['usuario_nome'] ?? 'Medico';
        ?>
        <h1>Bem-vindo, Dr(a) <?= htmlspecialchars($nomeUsuario) ?> !</h1>
    
        <section class="section-principal">
            <div class="grid-container">
                
                <div class="card">
                    <a href="atendimentos-dia.php">
                        <img src="../../assets/img/Healthcare.png">
                        <p>Atendimentos do dia</p>
                    </a>                 
                </div>

                <div class="card">
                    <a href="prontuario.php">
                        <img src="../../assets/img/Medical Record.png" alt="Prontuário">
                        <p>Prontuários</p>
                    </a>
                </div>

                <div class="card">
                    <a href="calendario.php?modo=consultas&data">
                        <img src="../../assets/img/Task Planning.png" alt="Consulta Agendadas">
                        <p>Consultas Agendadas</p>
                    </a>
                </div>

                <div class="card">
                    <a href="lista-pacientes.php">
                        <img src="../../assets/img/User Group.png" alt="Pacientes">
                        <p>Pacientes</p>
                    </a>
                </div>

                <div class="card">
                    <a href="#" target="">
                        <img src="../../assets/img/Health Graph.png" alt="Relatórios">
                        <p>Relatórios</p>
                    </a>
                </div>

            </div>
    </section>
    </main>
</body>
</html>