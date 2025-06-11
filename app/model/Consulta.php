<?php

session_start(); // Inicia a sessão

require_once '../controller/ConsultaController.php';

class Consulta {
    public function __construct(
        private int $idConsulta,
        private string $motivo,
        private string $cor,
        private string $dataInicio,
        private string $dataFim,
        //private StatusConsulta $status, USAR ENUM OU NÃO?
        private string $status,
        private ?int $idAdministrador = null,
        private ?int $idSecretario = null,
        private int $idMedico,
        private int $idPaciente
    ) {}

    // Getters
    public function getId(): int {
        return $this->idConsulta;
    }

    public function getMotivo(): string {
        return $this->motivo;
    }

    public function getCor(): string {
        return $this->cor;
    }

    public function getDataInicio(): string {
        return $this->dataInicio;
    }

    public function getDataFim(): string {
        return $this->dataFim;
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
    public function setId(int $idConsulta): void {
        $this->idConsulta = $idConsulta;
    }

    public function setMotivo(string $motivo): void {
        $this->motivo = $motivo;
    }

    public function setCor(string $cor): void {
        $this->cor = $cor;
    }

    public function setDataInicio(string $dataInicio): void {
        $this->dataInico = $dataInicio;
    }

    public function setDataFim(string $dataFim): void {
        $this->dataFim = $dataFim;
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
