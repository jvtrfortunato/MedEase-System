<?php
require_once '../controller/PacienteController.php';

$controller = new PacienteController();
    $acao = $_POST['acao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($acao) {
        case 'salvarPaciente':
            $controller->salvarPaciente();
            break;
        case 'atualizarPaciente':
            $controller->atualizarPaciente($_POST);
            break;
        default:
            echo "Não foi possível gerenciar o paciente.";
    }
}

if (isset($_GET['acao']) && $_GET['acao'] === 'excluirPaciente' && isset($_GET['paciente_id'])) {
    $controller->excluirPaciente($_GET['paciente_id']);
}
