<?php

namespace App\Models;

require_once 'StatusConsulta.php';
require_once 'Endereco.php';
require_once 'Paciente.php';
require_once 'Medico.php';

class Consulta {
    public function __construct(
        private int $id,
        private string $data,
        private string $hora,
        private StatusConsulta $status,
        private int $salaAtendimento,
        private string $motivo,
        private int $idPaciente,
        private string $idMedico,
    ) {}

    public function getId(): int {
        return $this->id;
    }

    public function getData(): string {
        return $this->data;
    }
    
    public function setData($data): void {
        $this->data = $data;
    }

    public function getHora(): string {
        return $this->hora;
    }
    
    public function setHora($hora): void {
        $this->hora = $hora;
    }

    public function getStatus(): StatusConsulta { talvez esse get e set deve estar na classe StatusConsulta
        return $this->status;
    }
    
    public function setStatus($status): void {
        $this->status = $status;
    }

    public function getSalaAtendimento(): int {
        return $this->salaAtendimeto;
    }
    
    public function setSalaAtendimento($salaAtendimento): void {
        $this->salaAtendimento = $salaAtendimento;
    }

    public function getMotivo(): string {
        return $this->motivo;
    }
    
    public function setMotivo($motivo): void {
        $this->motivo = $motivo;
    }

    public function getIdPaciente(): int {
        return $this->idPaciente;
    }
    
    public function setIdPaciente($idPaciente): void {
        $this->idPaciente = $idPaciente;
    }

    public function getIdMedico(): int {
        return $this->idMedico;
    }
    
    public function setIdMedico($idMedico): void {
        $this->idMedico = $idMedico;
    }

    public function confirmarConsulta() {
        return "Consulta criada.";
    }
}

$endereco = new Endereco("Rua das Flores", 123, "Centro", "São Paulo", "SP", "01010-000");

$paciente = new Paciente(
    1,
    'Paciente Teste', 
    '999.999.999-99', 
    '99/99/9999', 
    $endereco, 
    ['(99)99999-9999'], 
    'Paciente@.com', 
    'UniMed'
);

$medico = new Medico(
    1, 
    'Medico Teste', 
    '999.999.999-99', 
    '(99)99999-9999', 
    'MedTeste@.com', 
    '123', 
    'Médico', 
    'CRM/SP-123456', 
    'Neurologista', 
    1
);


$consulta = new Consulta(
    1,
    '10/07/2025', 
    '13:00', 
    StatusConsulta::Pendente, 
    1, 
    'Motivo Teste', 
    $paciente->getId(), 
    $medico->getId()
);
    
var_dump($consulta);
echo $consulta->getStatus();
