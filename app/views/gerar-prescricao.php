<?php
require '../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Recebe os dados do POST
$medicamentos = json_decode($_POST['medicamentos'] ?? '[]', true);
$recomendacoes = $_POST['recomendacoes'] ?? '';

// Inicializa o DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Gera o HTML
ob_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Prescrição Médica</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; padding: 20px; }
        h1 { text-align: center; }
        .medicamento { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Prescrição Médica</h1>
    <p><strong>Data:</strong> <?php echo date('d/m/Y H:i'); ?></p>

    <?php foreach ($medicamentos as $index => $m): ?>
        <div class="medicamento">
            <strong>Medicamento <?php echo $index + 1; ?>:</strong><br>
            <?php echo "{$m['principioAtivo']} - {$m['concentracao']} - {$m['forma']}<br>Via: {$m['via']} | Receita: {$m['tipoReceita']}"; ?><br>
            <?php
                if ($m['intervalo']) echo "Intervalo: {$m['intervalo']}<br>";
                if ($m['frequencia']) echo "Frequência: {$m['frequencia']}<br>";
                if ($m['turno']) echo "Turno: {$m['turno']}<br>";
            ?>
            Início: <?php echo $m['inicioTratamento']; ?> |
            Duração: <?php echo "{$m['duracao']} {$m['duracaoTipo']}"; ?>
        </div>
    <?php endforeach; ?>

    <?php if ($recomendacoes): ?>
        <p><strong>Recomendações:</strong><br><?php echo nl2br($recomendacoes); ?></p>
    <?php endif; ?>
</body>
</html>
<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("prescricao.pdf", ["Attachment" => false]); // Abre no navegador
exit;