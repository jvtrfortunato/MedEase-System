<?php

namespace App\Models;

require_once 'StatusConsulta.php';
require_once 'Endereco.php';
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
        private int $idSecretario,
        private int $idPaciente,
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

    public function getStatus(): StatusConsulta { 
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

    //Métodos
    //Secretario
    public function agendarConsulta() {
        return "Calendário com horários disponíveis.";
    }

    public function selecionarHorario() {
        return "Formulário para a inserção dos dados da consulta.";
    }

    public function confirmarAgendamento() {
        return "Objeto Consulta criado.";
    }

    public function selecionarConsultaPaciente() {
        return "Lista de consultas do paciente.";
    }

    public function admitirPaciente() {
        return "Atualiza o status da consulta para PacienteAguardando.";
    }

    //Médico
    public function listarConsultasAgendadasDia() {
        return "Lista de consultas agendadas do dia.";
    }

    public function abrirConsulta() {
        return "Atualia o status da consulta para EmAndamento e o prontuário do paciente é aberto.";
    }

    public function finalizarConsulta() {
        return "Atualiza o status da consulta para Concluida e salva os dados no prontuário.";
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
