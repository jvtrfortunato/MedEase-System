<?php

namespace App\Models;

require_once 'Usuario.php';

class Medico extends Usuario {
    public function __construct(
        int $id,
        string $nome, 
        string $cpf,
        string $telefone, 
        string $email, 
        string $senha,
        string $tipo,
        protected string $crm,
        protected string $especialidade,
        protected int $salaAtendimento,
        protected array $historicoConsultas = []
    ) {
        parent::__construct($id, $nome, $cpf, $telefone, $email, $senha, $tipo);
    }

    public function listarConsultasAgendadasDia() {
        return "Lista de consultas agendadas do dia.";
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

/*$medico = new Medico(
    1, 
    'Medico Teste', 
    '999.999.999-99', 
    '(99)99999-9999', 
    'MedTeste@.com', 
    '123', 
    'Médico', 
    'CRM/SP-123456', 
    'Neurologista', 
    1);

var_dump($medico);*/
