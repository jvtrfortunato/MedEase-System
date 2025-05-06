<?php

namespace App\Models;

require_once 'Usuario.php';
require_once 'Endereco.php';

class Medico extends Usuario {
    public function __construct(
        int $idUsuario,
        string $nome, 
        string $cpf,
        string $telefone,
        string $dataNascimento,
        string $sexo,
        string $email, 
        string $senha,
        string $tipo,
        Endereco $endereco,
        private string $crm,
        private string $especialidade
    ) {
        parent::__construct(
            $idUsuario, 
            $nome, 
            $cpf, 
            $telefone,
            $dataNascimento,
            $sexo,
            $email,
            $senha, 
            $tipo, 
            $endereco
        );
    }

    // Getters
    public function getCrm(): string {
        return $this->crm;
    }

    public function getEspecialidade(): string {
        return $this->especialidade;
    }

    // Setters
    public function setCrm(string $crm): void {
        $this->crm = $crm;
    }
    
    public function setEspecialidade(string $especialidade): void {
        $this->especialidade = $especialidade;
    } 
}

$medico = new Medico(
    3, 
    'Medico Teste', 
    '999.999.999-99', 
    '(99)99999-9999', 
    'MedTeste@.com', 
    '123', 
    'Médico', 
    'CRM/SP-123456', 
    'Neurologista', 
    1);

//var_dump($medico);
