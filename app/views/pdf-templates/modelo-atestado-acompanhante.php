<?php 

    session_start();
    date_default_timezone_set('America/Sao_Paulo');
    
?>

<!-- modelo-atestado.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; display: flex; flex-direction: column; align-items: center;}
        h1 { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        label { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Atestado de Acompanhante</h1>

    <div class="section">
        <label>Nome:</label> <?php echo htmlspecialchars($_POST['nomeAcompanhante']); ?><br>
        <label>CPF:</label> <?php echo htmlspecialchars($_POST['cpfAcompanhante']); ?><br>
        <label>Parentesco:</label> <?php echo htmlspecialchars($_POST['parentesco']); ?><br>
        <label>Data:</label> <?php echo date('d/m/Y', strtotime($_POST['data'])); ?><br>
        <label>Horário de chegada:</label> <?php echo htmlspecialchars($_POST['horarioChegada']); ?><br>
        <label>Horário de chegada:</label> <?php echo htmlspecialchars($_POST['horarioSaida']); ?><br>
        <label>CID-10:</label> <?php echo htmlspecialchars($_POST['cid10']); ?>
    </div>

    <div class="section">
        <label>Texto:</label>
        <p><?php echo nl2br(htmlspecialchars($_POST['textoPrincipal'])); ?></p>
    </div>

    <p style="text-align:right; font-size:12px;">Emitido em: <?php echo date('d/m/Y H:i'); ?></p>
</body>
</html>