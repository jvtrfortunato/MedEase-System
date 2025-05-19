<?php

require_once 'HistoricoMedico.php';
require_once 'Anamnese.php';
require_once 'ExameFisico.php';
require_once 'Prescricao.php';
require_once 'Internacao.php';
require_once 'Documentacao.php';
require_once 'Paciente.php';

class Prontuario {
    public function __construct(
        //Identificação
        private int $idProntuario,
        private string $dataCriacao,

        //Histórico médico e familiar
        private HistoricoMedico $historicoMedico, 

        //Anamnese
        private Anamnese $anamnese,

        //Exame Físico
        private ExameFisico $exameFisico, 

        //Diagnóstico
        private string $diagnosticoPresuntivo,
        private string $diagnosticoDiferencial,
        private string $diagnosticoDefinitivo,
        private string $cid10,

        //Exames Solicitados
        private array $examesSolicitados = [],

        //Prescrição Médica
        private Prescricao $prescricao,

        //Evolução do Quadro Clínico (observações de consultas sucessivas)
        private string $evolucao,

        //Exames de Imagem e Procedimentos
        private string $laudosExamesImagens,
        private string $procedimentosRealizados,

        //Registros de Internação e Cirurgias
        private Internacao $internacao,

        //Documentação e Consentimentos
        private Documentacao $documentacao,
        
        //Agendamentos e Histórico de Consultas
        private $historicoProntuarios = [],

        //Observações Gerais e Notificações
        private string $doencasNotificacaoObrigatoria,
        private string $observacoesAdicionais,

        private Paciente $paciente,
        private int $idMedico
    ){}

    // Getters
    public function getIdProntuario(): int {
        return $this->idProntuario;
    }

    public function getDataCriacao(): string {
        return $this->dataCriacao;
    }

    public function getHistoricoMedico(): HistoricoMedico {
        return $this->historicoMedico;
    }

    public function getAnamnese(): Anamnese {
        return $this->anamnese;
    }

    public function getExameFisico(): ExameFisico {
        return $this->exameFisico;
    }

    public function getDiagnosticoPresuntivo(): string {
        return $this->diagnosticoPresuntivo;
    }

    public function getDiagnosticoDiferencial(): string {
        return $this->diagnosticoDiferencial;
    }

    public function getDiagnosticoDefinitivo(): string {
        return $this->diagnosticoDefinitivo;
    }

    public function getCid10(): string {
        return $this->cid10;
    }

    public function getExamesSolicitados(): array {
        return $this->examesSolicitados;
    }

    public function getPrescricao(): Prescricao {
        return $this->prescricao;
    }

    public function getEvolucao(): string {
        return $this->evolucao;
    }

    public function getLaudosExamesImagens(): string {
        return $this->laudosExamesImagens;
    }

    public function getProcedimentosRealizados(): string {
        return $this->procedimentosRealizados;
    }

    public function getInternacao(): Internacao {
        return $this->internacao;
    }

    public function getDocumentacao(): Documentacao {
        return $this->documentacao;
    }

    public function getHistoricoProntuarios(): array { //ISSO VAI MUDAR
        return $this->historicoProntuarios;
    }

    public function getDoencasNotificacaoObrigatoria(): string {
        return $this->doencasNotificacaoObrigatoria;
    }

    public function getObservacoesAdicionais(): string {
        return $this->observacoesAdicionais;
    }

    public function getPaciente(): Paciente {
        return $this->paciente;
    }

    public function getIdMedico(): int {
        return $this->idMedico;
    }

    // Setters
    public function setDataCriacao(string $dataCriacao): void {
        $this->dataCriacao = $dataCriacao;
    }

    public function setHistoricoMedico(HistoricoMedico $historicoMedico): void {
        $this->historicoMedico = $historicoMedico;
    }

    public function setAnamnese(Anamnese $anamnese): void {
        $this->anamnese = $anamnese;
    }

    public function setExameFisico(ExameFisico $exameFisico): void {
        $this->exameFisico = $exameFisico;
    }

    public function setDiagnosticoPresuntivo(string $diagnosticoPresuntivo): void {
        $this->diagnosticoPresuntivo = $diagnosticoPresuntivo;
    }

    public function setDiagnosticoDiferencial(string $diagnosticoDiferencial): void {
        $this->diagnosticoDiferencial = $diagnosticoDiferencial;
    }

    public function setDiagnosticoDefinitivo(string $diagnosticoDefinitivo): void {
        $this->diagnosticoDefinitivo = $diagnosticoDefinitivo;
    }

    public function setCid10(string $cid10): void {
        $this->cid10 = $cid10;
    }

    public function setPrescricao(Prescricao $prescricao): void {
        $this->prescricao = $prescricao;
    }

    public function setEvolucao(string $evolucao): void {
        $this->evolucao = $evolucao;
    }

    public function setLaudosExamesImagens(string $laudosExamesImagens): void {
        $this->laudosExamesImagens = $laudosExamesImagens;
    }

    public function setProcedimentosRealizados(string $procedimentosRealizados): void {
        $this->procedimentosRealizados = $procedimentosRealizados;
    }

    public function setInternacao(Internacao $internacao): void {
        $this->internacao = $internacao;
    }

    public function setDocumentacao(Documentacao $documentacao): void {
        $this->documentacao = $documentacao;
    }

    public function seHistoricoProntuarios(array $historicoProntuarios): void {
        $this->historicoProntuarios = $historicoProntuarios;
    }

    public function setDoencasNotificacaoObrigatoria(string $doencasNotificacaoObrigatoria): void {
        $this->doencasNotificacaoObrigatoria = $doencasNotificacaoObrigatoria;
    }

    public function setObservacoesAdicionais(string $observacoesAdicionais): void {
        $this->observacoesAdicionais = $observacoesAdicionais;
    }

    public function setPaciente(Paciente $paciente): void {
        $this->paciente = $paciente;
    }

    public function setIdMedico($idMedico): void {
        $this->idMedico = $idMedico;
    }
}
