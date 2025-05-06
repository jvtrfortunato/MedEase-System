<?php

namespace App\Models;

class HistoricoMedico {
    public function __construct(
        private string $doencasPreexistentes,
        private string $medicacoesUsoContinuo,
        private string $cirurgiasAnteriores,
        private string $alergiasMedicamentos,
        private string $historicoDoencasFamilia,
        private int $idProntuario
    ) {}

    // Getters
    public function getDoencasPreexistentes(): string {
        return $this->doencasPreexistentes;
    }

    public function getMedicacoesUsoContinuo(): string {
        return $this->medicacoesUsoContinuo;
    }

    public function getCirurgiasAnteriores(): string {
        return $this->cirurgiasAnteriores;
    }

    public function getAlergiasMedicamentos(): string {
        return $this->alergiasMedicamentos;
    }

    public function getHistoricoDoencasFamilia(): string {
        return $this->historicoDoencasFamilia;
    }

    public function getIdProntuario(): int {
        return $this->idProntuario;
    }

    // Setters
    public function setDoencasPreexistentes(string $doencasPreexistentes): void {
        $this->doencasPreexistentes = $doencasPreexistentes;
    }

    public function setMedicacoesUsoContinuo(string $medicacoesUsoContinuo): void {
        $this->medicacoesUsoContinuo = $medicacoesUsoContinuo;
    }

    public function setCirurgiasAnteriores(string $cirurgiasAnteriores): void {
        $this->cirurgiasAnteriores = $cirurgiasAnteriores;
    }

    public function setAlergiasMedicamentos(string $alergiasMedicamentos): void {
        $this->alergiasMedicamentos = $alergiasMedicamentos;
    }

    public function setHistoricoDoencasFamilia(string $historicoDoencasFamilia): void {
        $this->historicoDoencasFamilia = $historicoDoencasFamilia;
    }

    public function setIdProntuario(int $idProntuario): void {
        $this->idProntuario = $idProntuario;
    }
}
