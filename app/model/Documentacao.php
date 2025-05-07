<?php

namespace App\Models;

class Documentacao {
    public function __construct(
        private int $idDocumentacao,
        private string $termosConsentimento,
        private Atestado $atestado,
        private string $declaracoesSaude,
        private int $idProntuario
    ) {}

    // Getters
    public function getIdDocumentacao(): int {
        return $this->idDocumentacao;
    }

    public function getTermosConsentimento(): string {
        return $this->termosConsentimento;
    }

    public function getAtestado(): Atestado {
        return $this->atestado;
    }

    public function getDeclaracoesSaude(): string {
        return $this->declaracoesSaude;
    }

    public function getIdProntuario(): int {
        return $this->idProntuario;
    }

    // Setters
    public function setIdDocumentacao(int $idDocumentacao): void {
        $this->idDocumentacao = $idDocumentacao;
    }

    public function setTermosConsentimento(string $termosConsentimento): void {
        $this->termosConsentimento = $termosConsentimento;
    }

    public function setAtestado(Atestado $atestado): void {
        $this->atestado = $atestado;
    }

    public function setDeclaracoesSaude(string $declaracoesSaude): void {
        $this->declaracoesSaude = $declaracoesSaude;
    }

    public function setIdProntuario(int $idProntuario): void {
        $this->idProntuario = $idProntuario;
    }
}
