<?php
require_once '../controller/ConsultaController.php';

$controller = new ConsultaController();
$acao = $_POST['acao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($acao) {
        case 'salvarConsulta':
            $controller->salvarConsulta();
            break;
        case 'editarConsulta':
            $controller->editarConsulta();
            break;
        case 'deletarConsulta':
            $controller->deletarConsulta();
            break;
        default:
            echo "Erro ao gerenciar consulta.";
    }
}

if (isset($_GET['acao']) && $_GET['acao'] === 'iniciarConsulta' && isset($_GET['consulta_id'])) {
    $controller->iniciarConsulta();
}
