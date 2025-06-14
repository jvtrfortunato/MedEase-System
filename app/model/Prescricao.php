<?php

class Prescricao {
    public function __construct(
        private int $idPrescricao,
        private array $medicamentos,
        private ?string $recomendacoes,
        private ?int $idProntuario = null
    ) {}

    // Getters
    public function getIdPrescricao(): int {
        return $this->idPrescricao;
    }

    public function getMedicamentos(): array {
        return $this->medicamentos;
    }

    public function getRecomendacoes(): string {
        return $this->recomendacoes;
    }

    public function getIdProntuario(): int {
        return $this->idProntuario;
    }

    // Setters
    public function setIdPrescricao(int $idPrescricao): void {
        $this->idPrescricao = $idPrescricao;
    }

    public function setMedicamentos(array $medicamentos): void {
        $this->medicamentos = $medicamentos;
    }

    public function setRecomendacoes(string $recomendacoes): void {
        $this->recomendacoes = $recomendacoes;
    }

    public function setIdProntuario(int $idProntuario): void {
        $this->idProntuario = $idProntuario;
    }
}
