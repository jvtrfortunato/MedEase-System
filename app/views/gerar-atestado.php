<?php
require '../../vendor/autoload.php'; // ajuste se o autoload estiver em outro caminho

use Dompdf\Dompdf;
use Dompdf\Options;

// Verifica se a ação é "imprimir"
if ($_POST['acao'] !== 'imprimir') {
    die("Ação inválida.");
}

// Inicializa o DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Gera o conteúdo HTML do PDF
ob_start();
$tipo = $_POST['tipoAtestado'] ?? '';

switch ($tipo) {
    case 'comparecimento':
        require __DIR__ . '/pdf-templates/modelo-atestado-comparecimento.php';
        break;
    case 'afastamento':
        require __DIR__ . '/pdf-templates/modelo-atestado-afastamento.php';
        break;
    case 'acompanhante':
        require __DIR__ . '/pdf-templates/modelo-atestado-acompanhante.php';
        break;
    default:
        die("Tipo de atestado inválido.");
}
$html = ob_get_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("atestado.pdf", ["Attachment" => false]); // false = abrir no navegador
exit;
