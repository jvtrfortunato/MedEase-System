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
        protected int $idMedico,
        protected string $crm,
        protected string $especialidade
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

    public function getCrm(): string {
        return $this->crm;
    }
    
    public function setCrm($crm): void {
        $this->crm = $crm;
    }

    public function getEspecialidade(): string {
        return $this->especialidade;
    }
    
    public function setEspecialidade($especialidade): void {
        $this->especialidade = $especialidade;
    } 

    public function selecionarConsulta() {
        return "Dados da consulta específica.";
    }

    public function atualizarProntuarioEletronico() {
        return "Lista de todos os pacientes.";
    }

    public function selecionarPaciente() {
        return "Prontuário do paciente aberto.";
    }

    public function ConfirmarAtualizacaoProntuario() {
        return "Modificações do prontuário salvas e registros atualizados.";
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
