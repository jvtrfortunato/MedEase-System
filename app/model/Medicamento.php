<?php

class Medicamento {
    public function __construct(
        private int $idMedicamento,
        private string $nomeMedicamento,
        private string $concentracao,
        private string $formaFarmaceutica,
        private string $viaAdministracao,
        private string $tipoReceita,
        private string $dose,
        private string $frequenciaDose,
        private string $dataInicio,
        private int $quantidadeDuracao,
        private string $diaMesOuAno,
        private ?int $idPrescricao = null
    ) {}

    // Getters
    public function getIdMedicamento(): int {
        return $this->idMedicamento;
    }

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

    public function getIdPrescricao(): int {
        return $this->idPrescricao;
    }

    // Setters
    public function setIdMedicamento(string $idMedicamento): void {
        $this->idMedicamento = $idMedicamento;
    }

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

    public function setIdPrescricao(int $idPrescricao): void {
        $this->idPrescricao = $idPrescricao;
    }
}
