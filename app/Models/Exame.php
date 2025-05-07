<?php

class Exame {
    public function __construct(
        private int $idExame,
        private string $nomeExame,
        private int $idProntuario
    ) {}

    // Getters
    public function getIdExame(): int {
        return $this->idExame;
    }

    public function getNomeExame(): string {
        return $this->nomeExame;
    }

    public function getIdProntuario(): int {
        return $this->idProntuario;
    }

    // Setters
    public function setIdExame(int $idExame): void {
        $this->idExame = $idExame;
    }

    public function setNomeExame(string $nomeExame): void {
        $this->nomeExame = $nomeExame;
    }

    public function setIdProntuario(int $idProntuario): void {
        $this->idProntuario = $idProntuario;
    }
}
