<?php

namespace App\Models;

require_once 'Paciente.php';
require_once 'Medico.php';
require_once 'Anamnese.php';
require_once 'ExameFisico.php';
require_once 'Exame.php';
require_once 'Prescricao.php';

class Prontuario {
    public function __construct(
        //Identificação
        private int $id,
        private int $idPaciente,
        private int $idMedicoResponsavel,
        private string $dataCriacaoProntuario,

        //Histórico médico e familiar
        private string $doencasPreExistentes,
        private string $medcacoesUsoContinuo,
        private string $cirurugiasAnteriores,
        private string $alergiasMedicamentos,
        private array $historicoDoencasFamilia, 

        //Anamnese
        private Anamnese $anamnese,

        //Exame Físico
        private ExameFisico $exameFisico, 

        //Diagnóstico
        private string $diagnosticoPresuntivo,
        private string $diagnosticoDiferencial,
        private string $diagnotiscoDefinitivo,
        private string $cid10,

        //Exames Solicitados
        private array $examesSolicitados = [],

        //Prescrição Médica
        private Prescricao $prescricao,

        //Evolução do Quadro Clínico (observações de consultas sucessivas)
        private string $evolucaoQuadroClinico,

        //Exames de Imagem e Procedimentos
        private string $laudosExamesImagens,
        private string $procedimentosRealizados,

        //Registros de Internação e Cirurgias
        private string $dataAdmissaoEAlta,
        private string $diagnosticoInternacao,
        private string $procedimentosCirurgicos,
        private string $medicosResponsaveis,

        //Documentação e Consentimentos
        private string $termosConsentimentoParaProcedimentos,
        private string $atestados, //ISSO AQUI PROVAVELMENTE VAI SER UM OBJETO DO TIPO ATESTADO - CRIAR TAMBÉM A TELA
        private string $declaracoesSaudeFormuláriosLegais,
        
        //Agendamentos e Histórico de Consultas
        private array $idProntuarios = [],

        //Observações Gerais e Notificações
        private string $doencasNotificacaoObrigatoria,
        private string $observacoesAdicionais
    ){}

    //getters e setters
    //Identificação
    public function getId(): int {  //ARRUMAR TODOS OS MÉTODOS DE TODAS AS CLASSES
        return $this->id;
    }
    
    public function getIdPaciente(): int {
        return $this->idPaciente;
    }
    
    public function getIdMedico(): int {
        return $this->idMedico;
    }
    
    public function setIdMedico($idMedico): void { 
        $this->idMedico = $idMedico;
    }

    public function getDataUltimaAtualizacao(): string {
        return $this->dataUltimaAtualizacao;
    }
    
    public function setDataUltimaAtualizacao($dataUltimaAtualizacao): void {
        $this->dataUltimaAtualizacao = $dataUltimaAtualizacao;
    }


    //Informações Clínicas
    public function getHistoricoMedico(): string {
        return $this->hisoricoMedico;
    }
    
    public function setHistoricoMedico($historicoMedico): void {
        $this->historicoMedico = $historicoMedico;
    }

    public function getSintomas(): string {
        return $this->sintomas;
    }
    
    public function setSintomas($sintomas): void {
        $this->sintomas = $sintomas;
    }

    public function getDiagnostico(): string {
        return $this->diagnostico;
    }
    
    public function setDiagnostico($diagnostico): void {
        $this->diagnostico = $diagnostico;
    }

    public function getAnamnese(): Anamnese { //Talvez esse get e set tem que estar na classe Anamnese
        return $this->anamnese;
    }
    
    public function setAnamnese($anamnese): void {
        $this->anamnese = $anamnese;
    }

    public function getExameFisico(): ExameFisico { //Talvez esse get e set tem que estar na classe ExameFisico
        return $this->exameFisico;
    }
    
    public function setExameFisico($exameFisico): void {
        $this->exameFisico = $exameFisico;
    }

    public function getPrescricao(): Prescricao { //Talvez esse get e set tem que estar na classe ExameFisico
        return $this->prescricao;
    }
    
    public function setPrescricao($prescricao): void {
        $this->prescricao = $prescricao;
    }

    public function getHistoricoDiagnosticos(): array {
        return $this->historicoDiagnosticos;
    }
    
    public function setHistoricoDiagnosticos($historicoDiagnosticos): void {
        $this->historicoDiagnosticos = $historicoDiagnosticos;
    }


    //Dados vitais e exames
    public function getPeso(): string {
        return $this->peso;
    }
    
    public function setPeso($peso): void {
        $this->peso = $peso;
    }

    public function getAltura(): string {
        return $this->altura;
    }
    
    public function setAltura($altura): void {
        $this->altura = $altura;
    }

    public function getExamesSolicitados(): array {
        return $this->examesSolicitados;
    }
    
    public function setExamesSolicitados($examesSolicitados): void {
        $this->examesSolicitados = $examesSolicitados;
    }

    public function getResultadosExames(): array {
        return $this->resultadosExames;
    }
    
    public function setResultadosExames($resultadosExames): void {
        $this->resultadosExames = $resultadosExames;
    }

    public function getLaudoExames(): array {
        return $this->laudoExames;
    }
    
    public function setLaudoExames($laudoExames): void {
        $this->laudoExames = $laudoExames;
    }


    //Outros
    public function getSexo(): string {
        return $this->sexo;
    }
    
    public function setSexo($sexo): void {
        $this->sexo = $sexo;
    }

    public function getNomeMae(): string {
        return $this->nomeMae;
    }
    
    public function setNomeMae($nomeMae): void {
        $this->nomeMae = $nomeMae;
    }

    public function getNomePai(): string {
        return $this->nomePai;
    }
    
    public function setNomePai($nomePai): void {
        $this->nomePai = $nomePai;
    }

    public function getNomeConjuge(): string {
        return $this->nomeConjuge;
    }
    
    public function setNomeConjuge($nomeConjuge): void {
        $this->nomeConjuge = $nomeConjuge;
    }

    public function getLocalNascimento(): string {
        return $this->localNascimento;
    }
    
    public function setLocalNascimento($localNascimento): void {
        $this->localNascimento = $localNascimento;
    }

    public function getProfissao(): string {
        return $this->profissao;
    }
    
    public function setProfissao($profissao): void {
        $this->profissao = $profissao;
    }

    public function getProcedencia(): string {
        return $this->procedencia;
    }
    
    public function setProcedencia($procedencia): void {
        $this->procedencia = $procedencia;
    }

    public function getRelatorioEncaminhamento(): string {
        return $this->relatorioEncaminhamento;
    }
    
    public function setRelatorioEncaminhamento($relatorioEncaminhamento): void {
        $this->relatorioEncaminhamento = $relatorioEncaminhamento;
    }

    public function getHistoricoEncaminhamentos(): array {
        return $this->historicoEncaminhamentos;
    }
    
    public function setHistoricoEncaminhamentos($historicoEncaminhamentos): void {
        $this->historicoEncaminhamentos = $historicoEncaminhamentos;
    }

    public function getAntecedentesHospitalares(): array {
        return $this->antecedentesHospitalares;
    }
    
    public function setAntecedentesHospitalares($antecedentesHospitalares): void {
        $this->antecedentesHospitalares = $antecedentesHospitalares;
    }

    //Métodos
    public function solicitarExame() {
        return "Formulário com um campo de texto para selecionar o exame específico";
    }

    public function salvarExame() {
        return "Armazena o exame em uma lista.";
    }

    public function finalizarSolicitacaoExame() {
        return "Registra os exames solicitados no prontuário do paciente e disponibiliza para impressão.";
    }

    //Médico
    public function selecionarProntuario() {
        return "Prontuário eletrônico do paciente aberto.";
    }

    public function confirmarAlteracoesProntuario() {
        return "Modificações salvas e registros atualizados.";
    }

    public function inserirResultadoExame() {
        return "Tela que possibilita a inserção dos dados do exame.";
    }

    public function salvarResultadoExame() {
        return "Associa o resultado ao exame solicitado e o salva no prontuário.";
    }
}

$prontuario = new Prontuario(
    //Identificação
    1,
    $paciente->getId(),
    $medico->getId(),
    '05/03/2025',

    //Informações Clínicas
    'Dor de cabeça',
    $anamnese,
    $exameFisico,
    'Enxaqueca',
    ['Enxaqueca'],
    $prescricao,

    //Dados Vitais e Exames
    '90,2 Kg',
    '1,85 m',
    'Hemograma completo',
    ['Hemograma completo'],
    ['Resultado teste'],
    ['Laudo teste'],

    //Outros
    'Masculino',
    'Paulo',
    'Maria',
    'Mariana',
    'Presidente Prudente - SP',
    'Desenvolvedor',
    'Pirapozinho - SP',
    'Nenhum encaminhamento',
    ['Histórico encaminhamento teste'],
    ['Antecedentes hospitalares teste'] //ARRUMAR TODOS DESSE AQUI
);

var_dump($prontuario);
