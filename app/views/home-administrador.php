<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link href="../../assets/css/index-usuarios.css" rel="stylesheet">
    <title>Admistrador</title>
</head>
<body>
    <header>
        <a class="logo" href="login.php">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    
    <main>
        <?php
        session_start();
        $nomeUsuario = $_SESSION['usuario_nome'] ?? 'Administrador';
        $idAdministrador = $_SESSION['administrador_id']
        ?>
        <h1>Bem-vindo(a), <?= htmlspecialchars($nomeUsuario) ?>!</h1>

        <section class="section-principal">
            <div class="grid-container">
                
                <div class="card">
                    <a href="gerenciar-pacientes.php" target="">
                        <img src="../../assets/img/User.png" alt="Pacientes">
                        <p>Gerenciar Pacientes</p>
                    </a>
                </div>

                <div class="card">
                    <a href="calendario-joao.php">
                        <img src="../../assets/img/Planner.png" alt="Agendar Consulta">
                        <p>Agenda</p>
                    </a>
                </div>

                <div class="card">
                    <a href="lista-prontuarios.php" target="">
                        <img src="../../assets/img/Medical Record.png" alt="Prontuário">
                        <p>Prontuários</p>
                    </a>
                </div>

                <div class="card">
                    <a href="gerenciar-profissionais.php" target="">
                        <img src="../../assets/img/Admin Settings Male.png" alt="Gerenciar Profissionais">
                        <p>Gerenciar Profissionais</p>
                    </a>
                </div>

                <div class="card">
                    <a href="relatorios.php" target="">
                        <img src="../../assets/img/Health Graph.png" alt="Relatórios">
                        <p>Relatórios</p>
                    </a>
                </div>

            </div>
    </section>
    </main>
</body>
</html>