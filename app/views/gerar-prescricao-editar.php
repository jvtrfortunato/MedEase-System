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
            <?php echo "{$m['nome_medicamento']} - {$m['concentracao']} - {$m['forma_farmaceutica']}<br>Via: {$m['via_administracao']} | Receita: {$m['tipo_receita']}"; ?><br>
            <?php
                if ($m['intervalo_dose']) echo "Intervalo: {$m['intervalo_dose']}<br>";
                if ($m['frequencia_dose']) echo "Frequência: {$m['frequencia_dose']}<br>";
                if ($m['turno_dose']) echo "Turno: {$m['turno_dose']}<br>";
            ?>
            Início: <?php echo $m['data_inicio']; ?> |
            Duração: <?php echo "{$m['quantidade_duracao']} {$m['tipo_duracao']}"; ?>
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