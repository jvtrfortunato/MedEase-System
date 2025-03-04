<?php

namespace App\Models;

require_once "Usuario.php";

class Secretario extends Usuario {

    public function __construct(
        string $nome, 
        string $cpf,
        string $telefone, 
        string $email, 
        string $senha, 
        string $tipo, 
        protected string $horarioTrabalho,
        protected array $historicoAtividades = []
    ) {
        parent::__construct($nome, $cpf, $telefone, $email, $senha, $tipo);
    }

    public function agendarConsulta() {
        return "Agendando consultas.";
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
    'Secretario Teste', 
    '999.999.999-99', 
    '(99)99999-9999', 
    'SecTeste@.com', 
    '123', 
    'Secretário', 
    '8:00 - 17:00');

var_dump($secretario);
echo $secretario->agendarConsulta() . "\n";
echo $secretario->buscarPaciente() . "\n";
echo $secretario->selecionarPaciente() . "\n";
echo $secretario->selecionarConsulta();
