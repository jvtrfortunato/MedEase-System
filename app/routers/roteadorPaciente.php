<?php
require_once '../controller/PacienteController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new PacienteController();
    $acao = $_POST['acao'] ?? '';

    switch ($acao) {
        case 'salvarPaciente':
            $controller->salvarPaciente();
            break;
        case 'editarPaciente':
            $controller->editarPaciente();
            break;
        case 'deletarPaciente':
            $controller->deletarPaciente();
            break;
        default:
            echo "Não foi possível gerenciar o paciente.";
    }
}