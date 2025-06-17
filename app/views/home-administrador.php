<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'administrador') {
    header("Location: login.php");
    exit;
}

$nomeUsuario = htmlspecialchars($_SESSION['usuario_nome'] ?? 'Administrador');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link href="../../assets/css/index-usuarios.css" rel="stylesheet">
    <title>Administrador - MedEase</title>
</head>
<body>
    <header>
        <a class="logo" href="home-administrador.php">MedEase</a>    
        <a href="../routers/logout.php">sair</a>
    </header>
    
    <main>
        <h1>Bem-vindo(a), <?= $nomeUsuario ?>!</h1>

        <section class="section-principal">
            <div class="grid-container">
                
                <div class="card">
                    <a href="gerenciar-pacientes.php">
                        <img src="../../assets/img/User.png" alt="Pacientes" loading="lazy">
                        <p>Gerenciar Pacientes</p>
                    </a>
                </div>

                <div class="card">
                    <a href="calendario-joao.php">
                        <img src="../../assets/img/Planner.png" alt="Agenda" loading="lazy">
                        <p>Agenda</p>
                    </a>
                </div>

                <div class="card">
                    <a href="lista-prontuarios.php">
                        <img src="../../assets/img/Medical Record.png" alt="Prontuários" loading="lazy">
                        <p>Prontuários</p>
                    </a>
                </div>

                <div class="card">
                    <a href="gerenciar-profissionais.php">
                        <img src="../../assets/img/Admin Settings Male.png" alt="Gerenciar Profissionais" loading="lazy">
                        <p>Gerenciar Profissionais</p>
                    </a>
                </div>

                <div class="card">
                    <a href="relatorios.php">
                        <img src="../../assets/img/Health Graph.png" alt="Relatórios" loading="lazy">
                        <p>Relatórios</p>
                    </a>
                </div>

            </div>
        </section>
    </main>

</body>
</html>