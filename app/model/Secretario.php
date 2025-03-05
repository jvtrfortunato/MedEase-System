<?php

namespace App\Models;

require_once "Usuario.php";

class Secretario extends Usuario {

    public function __construct(
        string $id,
        string $nome, 
        string $cpf,
        string $telefone, 
        string $email, 
        string $senha, 
        string $tipo, 
        protected string $horarioTrabalho,
        protected array $historicoAtividades = [] //Talvez uma classe compositória
    ) {
        parent::__construct($id, $nome, $cpf, $telefone, $email, $senha, $tipo);
    }

    public function gethorarioTrabalho(): string {
        return $this->horarioTrabalho;
    }
    
    public function setHorarioTrabalho($horarioTrabalho): void {
        $this->horarioTrabalho = $horarioTrabalho;
    }

    public function getHistoricoAtividades(): array {
        return $this->historicoAtividades;
    }
    
    public function setHistoricoAtividades($historicoAtividades): void {
        $this->historicoAtividades = $historicoAtividades;
    }

    public function agendarConsulta() {
        return "Calendário com horários disponíveis é aberto.";
    }

    public function selecionarHorarioAgendamento($data, $hora) {
        return "Formulário aberto para a inserção dos dados da consulta.";
    }

    public function buscarPaciente() {
        return "Lista de pacientes.";
    }

    public function selecionarPaciente() {
        return "Histórico de consultas do paciente (finalizadas, em andamento e agendadas).";
    }

    public function selecionarConsulta() {
        return "Dados da consulta selecionada.";
    }
}

$secretario = new Secretario(
    1,
    'Secretario Teste', 
    '999.999.999-99', 
    '(99)99999-9999', 
    'SecTeste@.com', 
    '123', 
    'Secretário', 
    '8:00 - 17:00');

var_dump($secretario);
