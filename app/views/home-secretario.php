<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link href="../../assets/css/index-usuarios.css" rel="stylesheet">
    <title>Secretário</title>
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    
    <main>
        <?php
        session_start();
        $nomeUsuario = $_SESSION['usuario_nome'] ?? 'Secretario';
        ?>
        <h1>Bem-vindo(a), <?= htmlspecialchars($nomeUsuario) ?>!</h1>
        
        <section class="section-principal">
            <div class="grid-container">
                
                <div class="card">
                    <a href="gerenciar-pacientes.php">
                        <img src="../../assets/img/User.png" alt="Pacientes">
                        <p>Pacientes</p>
                    </a>
                </div>

                <div class="card">
                    <a href="calendario-joao.php">
                        <img src="../../assets/img/Planner.png" alt="Agendar Consulta">
                        <p>Agendar Consulta</p>
                    </a>
                </div>

            </div>
    </section>
    </main>
</body>
</html>