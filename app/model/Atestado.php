<?php

class Atestado {
    public function __construct(
        private ?int $idAtestado = null,
        private string $cid10,
        private string $textoPrincipal,
        private ?int $idDocumentacao = null
    ) {}

    // Getters
    public function getIdAtestado(): int {
        return $this->idAtestado;
    }

    public function getCid10(): string {
        return $this->cid10;
    }

    public function getTextoPrincipal(): string {
        return $this->textoPrincipal;
    }

    public function getIdDocumentacao(): int {
        return $this->idDocumentacao;
    }

    // Setters
    public function setIdAtestado(int $idAtestado): void {
        $this->idAtestado = $idAtestado;
    }

    public function setCid10(string $cid10): void {
        $this->cid10 = $cid10;
    }

    public function setTextoPrincipal(string $textoPrincipal): void {
        $this->textoPrincipal = $textoPrincipal;
    }

    public function setIdDocumentacao(int $idDocumentacao): void {
        $this->idDocumentacao = $idDocumentacao;
    }
}
