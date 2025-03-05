<?php

namespace App\Models;

class Prontuario {
    public function __construct(
        //Identificação
        private int $id,
        private int $idPaciente,
        private int $idMedicoResponsavel, //talvez colocar Ids de todos medicos responsaveis em um array
        private string $dataUltimaAtualizacao,

        //Informações Clínicas
        private string $historicoMedico,
        private string $sintomas,
        private string $diagnostico,
        private Anamnese $anamnese,
        private ExameFisico $exameFisico,
        private Prescricao $prescricao, 
        private array $historicoDiagnosticos = [], 

        //Dados vitais e Exames
        private string $peso,
        private string $altura,
        private string $exameSolicitado, //Talvez implementar uma classe Exame
        private array $examesSolicitados = [], 
        private array $resultadosExames = [],
        private array $laudoExames = [],

        //Outros
        private string $sexo,
        private string $nomeMae,
        private string $nomePai,
        private string $nomeConjuge,
        private string $localNascimento,
        private string $profissao,
        private string $procedencia, //local de origem
        private string $relatorioEncaminhamento, //encaminhamento para outro medico
        private array $historicoEncaminhamentos = [],
        private array $antecedentesHospitalares = []
    ){}

    //getters e setters
    //Identificação
    public function getId(): int {
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
}
