<?php

require_once 'Atestado.php';

class AtestadoComparecimento extends Atestado {
    public function __construct(
        int $idAtestado,
        string $cid10,
        string $textoPrincipal,
        ?int $idDocumentacao = null,
        protected string $data,
        protected string $horarioChegada,
        protected string $horarioSaida   
    ) {
        parent::__construct($idAtestado, $cid10, $textoPrincipal, $idDocumentacao);
    }

    // Getters
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
    public function setData(string $data): void {
        $this->data = $data;
    }

    public function setHorarioChegada(string $horarioChegada): void {
        $this->data = $horarioChegada;
    }

    public function setHorarioSaida(string $horarioSaida): void {
        $this->data = $horarioSaida;
    }
}