<?php

require_once 'StatusConsulta.php';
require_once '../controller/ConsultaController.php';

class Consulta {
    public function __construct(
        private int $idConsulta,
        private string $motivo,
        private string $data,
        private string $hora,
        //private StatusConsulta $status, USAR ENUM OU NÃO?
        private string $status,
        private int $idPaciente,
        private int $idMedico,
        private ?int $idSecretario = null,
        private ?int $idAdministrador = null
    ) {}

    // Getters
    public function getId(): int {
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

    public function getStatus(): string {
        return $this->status;
    }

    public function getIdPaciente(): int {
        return $this->idPaciente;
    }

    public function getIdMedico(): int {
        return $this->idMedico;
    }

    public function getIdSecretario(): int {
        return $this->idSecretario;
    }

    public function getIdAdministrador(): int {
        return $this->idAdministrador;
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

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function setIdPaciente(int $idPaciente): void {
        $this->idPaciente = $idPaciente;
    }

    public function setIdMedico(int $idMedico): void {
        $this->idMedico = $idMedico;
    }

    public function setIdSecretario(int $idSecretario): void {
        $this->idSecretario = $idSecretario;
    }

    public function setIdAdministrador(int $idAdministrador): void {
        $this->idAdministrador = $idAdministrador;
    }
}

// Controller dispatch
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
