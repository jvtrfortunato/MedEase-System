<?php

require_once 'StatusConsulta.php';
require_once 'Secretario.php';
require_once 'Paciente.php';
require_once 'Medico.php';
require_once 'ConsultaController.php';

class Consulta {
    public function __construct(
        private int $idConsulta,
        private string $motivo,
        private string $data,
        private string $hora,
        private StatusConsulta $status,
        private int $idSecretario,
        private int $idPaciente,
        private int $idMedico
    ) {}

    // Getters
    public function getIdConsulta(): int {
        return $this->idConsulta;
    }

    public function getMotivo(): string {
        return $this->motivo;
    }

    public function getData(): string {
        return $this->data;
    }

    public function getHora(): string {
        return $this->hora;
    }

    public function getSalaAtendimento(): string {
        return $this->salaAtendimento;
    }

    public function getStatus(): StatusConsulta {
        return $this->status;
    }

    public function getSecretario(): Secretario {
        return $this->secretario;
    }

    public function getPaciente(): Paciente {
        return $this->paciente;
    }

    public function getMedico(): Medico {
        return $this->medico;
    }

    // Setters
    public function setMotivo(string $motivo): void {
        $this->motivo = $motivo;
    }

    public function setData(string $data): void {
        $this->data = $data;
    }

    public function setHora(string $hora): void {
        $this->hora = $hora;
    }

    public function setSalaAtendimento(string $salaAtendimento): void {
        $this->salaAtendimento = $salaAtendimento;
    }

    public function setStatus(StatusConsulta $status): void {
        $this->status = $status;
    }

    public function setSecretario(Secretario $secretario): void {
        $this->secretario = $secretario;
    }

    public function setPaciente(Paciente $paciente): void {
        $this->paciente = $paciente;
    }

    public function setMedico(Medico $medico): void {
        $this->medico = $medico;
    }
}

$controller = new ConsultaController();

$acao = $_POST['acao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($acao) {
        case 'salvar':
            $controller->salvarConsulta();
            break;
        case 'editar':
            $controller->editarConsulta();
            break;
        case 'deletar':
            $controller->deletarConsulta();
            break;
        default:
            echo "Ação inválida.";
    }
}
