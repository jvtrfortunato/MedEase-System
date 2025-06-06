<?php
require_once '../controller/MedicoController.php';

$controller = new MedicoController();
    $acao = $_POST['acao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($acao) {
        case 'atualizarMedico':
            $controller->atualizarMedico($_POST);
            break;
        default:
            echo "Não foi possível gerenciar o médico.";
    }
}

if (isset($_GET['acao']) && $_GET['acao'] === 'excluirMedico' && isset($_GET['medico_id'])) {
    $controller->excluirMedico($_GET['medico_id']);
}