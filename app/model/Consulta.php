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
