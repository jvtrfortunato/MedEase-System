<?php

require_once 'StatusConsulta.php';
require_once 'Secretario.php';
require_once 'Paciente.php';
require_once 'Medico.php';

class Consulta {
    public function __construct(
        private int $idConsulta,
        private string $motivo,
        private string $data,
        private string $hora,
        private string $salaAtendimento,
        private StatusConsulta $status,
        private Secretario $secretario,
        private Paciente $paciente,
        private Medico $medico
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

$consulta = new Consulta(
    1,
    '10/07/2025', 
    '13:00', 
    StatusConsulta::Agendada, 
    1, 
    'Motivo Teste', 
    $paciente->getId(), 
    $medico->getId()
);
    
var_dump($consulta);
