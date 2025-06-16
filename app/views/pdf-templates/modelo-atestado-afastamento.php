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
    <h1>Atestado de Afastamento</h1>

    <div class="section">
        <label>Nome:</label> <?php echo htmlspecialchars($_SESSION['paciente_nome']); ?><br>
        <label>Dias de afastamento:</label> <?php echo htmlspecialchars($_POST['numeroDias']); ?><br>
        <label>Data de início:</label> <?php echo date('d/m/Y', strtotime($_POST['dataInicio'])); ?><br>
        <label>Data prevista para o retorno:</label> <?php echo date('d/m/Y', strtotime($_POST['dataRetorno'])); ?><br>
        <label>CID-10:</label> <?php echo htmlspecialchars($_POST['cid10']); ?>
    </div>

    <div class="section">
        <label>Texto:</label>
        <p><?php echo nl2br(htmlspecialchars($_POST['textoPrincipal'])); ?></p>
    </div>

    <p style="text-align:right; font-size:12px;">Emitido em: <?php echo date('d/m/Y H:i'); ?></p>
</body>
</html>