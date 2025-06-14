<?php

require_once 'Atestado.php';

class AtestadoAcompanhante extends Atestado {
    public function __construct(
        int $idAtestado,
        string $cid10,
        string $textoPrincipal,
        ?int $idDocumentacao = null,
        protected string $nomeAcompanhante,
        protected string $cpfAcompanhante,
        protected string $parentescoAcompanhante, 
        protected string $data,
        protected string $horarioChegada,
        protected string $horarioSaida
    ) {
        parent::__construct($idAtestado, $cid10, $textoPrincipal, $idDocumentacao);
    }

    // Getters
    public function getNomeAcompanhante(): string {
        return $this->nomeAcompanhante;
    }

    public function getCpfAcompanhante(): string {
        return $this->cpfAcompanhante;
    }

    public function getParentescoAcompanhante(): string {
        return $this->parentescoAcompanhante;
    }

    public function getData(): string {
        return $this->data;
    }

    public function getHorarioChegada(): string {
        return $this->horarioChegada;
    }

    public function getHorarioSaida(): string {
        return $this->horarioSaida;
    }

    // Setters
    public function setNomeAcompanhante(string $nomeAcompanhante): void {
        $this->nomeAcompanhante = $nomeAcompanhante;
    }

    public function setCpfAcompanhante(string $cpfAcompanhante): void {
        $this->cpfAcompanhante = $cpfAcompanhante;
    }

    public function setParentescoAcompanhante(string $parentescoAcompanhante): void {
        $this->parentescoAcompanhante = $parentescoAcompanhante;
    }

    public function setData(string $data): void {
        $this->data = $data;
    }

    public function setHorarioChegada(string $horarioChegada): void {
        $this->horarioChegada = $horarioChegada;
    }

    public function setHorarioSaida(string $horarioSaida): void {
        $this->horarioSaida = $horarioSaida;
    }
}
