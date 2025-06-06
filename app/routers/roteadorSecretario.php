<?php
require_once '../controller/SecretarioController.php';

$controller = new SecretarioController();
    $acao = $_POST['acao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($acao) {
        case 'salvarSecretario':
            $controller->salvarSecretario($_POST);
            break;
        case 'atualizarSecretario':
            $controller->atualizarSecretario($_POST);
            break;
        default:
            echo "Não foi possível gerenciar o secretário.";
    }
}

if (isset($_GET['acao']) && $_GET['acao'] === 'excluirSecretario' && isset($_GET['secretario_id'])) {
    $controller->excluirSecretario($_GET['secretario_id']);
}
