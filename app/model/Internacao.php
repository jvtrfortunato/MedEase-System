<?php

class Internacao {
    public function __construct(
        private string $dataAdmissaoEAlta,
        private string $diagnosticoInternacao,
        private string $procedimentosCirurgicos,
        private string $medicosResponsaveis,
        private ?int $idProntuario = null
    ) {}

    // Getters
    public function getDataAdmissaoEAlta(): string {
        return $this->dataAdmissaoEAlta;
    }

    public function getDiagnosticoInternacao(): string {
        return $this->diagnosticoInternacao;
    }

    public function getProcedimentosCirurgicos(): string {
        return $this->procedimentosCirurgicos;
    }

    public function getMedicosResponsaveis(): string {
        return $this->medicosResponsaveis;
    }

    public function getIdProntuario(): int {
        return $this->idProntuario;
    }

    // Setters
    public function setDataAdmissaoEAlta(string $dataAdmissaoEAlta): void {
        $this->dataAdmissaoEAlta = $dataAdmissaoEAlta;
    }

    public function setDiagnosticoInternacao(string $diagnosticoInternacao): void {
        $this->diagnosticoInternacao = $diagnosticoInternacao;
    }

    public function setProcedimentosCirurgicos(string $procedimentosCirurgicos): void {
        $this->procedimentosCirurgicos = $procedimentosCirurgicos;
    }

    public function setMedicosResponsaveis(string $medicosResponsaveis): void {
        $this->medicosResponsaveis = $medicosResponsaveis;
    }

    public function setIdProntuario(int $idProntuario): void {
        $this->idProntuario = $idProntuario;
    }
}
