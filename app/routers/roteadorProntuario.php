<?php
require_once '../controller/ProntuarioController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ProntuarioController();
    $acao = $_POST['acao'] ?? '';

    switch ($acao) {
        case 'salvarProntuario':
            $controller->salvarProntuario();
            break;
        case 'editarProntuario':
            $controller->editarProntuario();
            break;
        case 'deletarProntuario':
            $controller->deletarProntuario();
            break;
        default:
            echo "Não foi possível salvar o prontuário.";
    }
}
