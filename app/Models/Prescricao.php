<?php

namespace App\Models;

class Prescricao {
    public function __construct(
        // Medicamento
        private string $nomeMedicamento,
        private string $concentracao,
        private string $formaFarmaceutica,
        private string $viaAdministracao,
        private string $tipoReceita,

        // Posologia
        private string $dose,
        private string $frequenciaDose,

        // Período de tratamento
        private string $dataInicio,
        private int $quantidadeDuracao,
        private string $diaMesOuAno,
        
        // Recomendações
        private string $recomendacoes,

        private int $idProntuario
    ) {}

    // Getters
    public function getNomeMedicamento(): string {
        return $this->nomeMedicamento;
    }

    public function getConcentracao(): string {
        return $this->concentracao;
    }

    public function getFormaFarmaceutica(): string {
        return $this->formaFarmaceutica;
    }

    public function getViaAdministracao(): string {
        return $this->viaAdministracao;
    }

    public function getTipoReceita(): string {
        return $this->tipoReceita;
    }

    public function getDose(): string {
        return $this->dose;
    }

    public function getFrequenciaDose(): string {
        return $this->frequenciaDose;
    }

    public function getDataInicio(): string {
        return $this->dataInicio;
    }

    public function getQuantidadeDuracao(): int {
        return $this->quantidadeDuracao;
    }

    public function getDiaMesOuAno(): string {
        return $this->diaMesOuAno;
    }

    public function getRecomendacoes(): string {
        return $this->recomendacoes;
    }

    public function getIdProntuario(): int {
        return $this->idProntuario;
    }

    // Setters
    public function setNomeMedicamento(string $nomeMedicamento): void {
        $this->nomeMedicamento = $nomeMedicamento;
    }

    public function setConcentracao(string $concentracao): void {
        $this->concentracao = $concentracao;
    }

    public function setFormaFarmaceutica(string $formaFarmaceutica): void {
        $this->formaFarmaceutica = $formaFarmaceutica;
    }

    public function setViaAdministracao(string $viaAdministracao): void {
        $this->viaAdministracao = $viaAdministracao;
    }

    public function setTipoReceita(string $tipoReceita): void {
        $this->tipoReceita = $tipoReceita;
    }

    public function setDose(string $dose): void {
        $this->dose = $dose;
    }

    public function setFrequenciaDose(string $frequenciaDose): void {
        $this->frequenciaDose = $frequenciaDose;
    }

    public function setDataInicio(string $dataInicio): void {
        $this->dataInicio = $dataInicio;
    }

    public function setQuantidadeDuracao(int $quantidadeDuracao): void {
        $this->quantidadeDuracao = $quantidadeDuracao;
    }

    public function setDiaMesOuAno(string $diaMesOuAno): void {
        $this->diaMesOuAno = $diaMesOuAno;
    }

    public function setRecomendacoes(string $recomendacoes): void {
        $this->recomendacoes = $recomendacoes;
    }

    public function setIdProntuario(int $idProntuario): void {
        $this->idProntuario = $idProntuario;
    }
}


$medicamento = new Medicamento(
    //Medicamento
    'Medicamento teste',
    'Concentração teste',
    'Forma farmaceutica teste',
    'Via administração teste',
    'Tipo receita teste',

    //Posologia
    'Dose teste',
    'Frequência dose teste',

    //Período de tratamento
    'Início teste',
    'Dias teste',
    
    //Outros
    'Recomendações teste'   //ARRUMAR TODOS DESSE AQUI
);

//var_dump($medicaento);