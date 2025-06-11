<?php

require_once 'Atestado.php';

class AtestadoAfastamento extends Atestado {
    public function __construct(
        int $idAtestado,
        string $cid10,
        string $textoPrincipal,
        ?int $idDocumentacao = null,
        protected int $diasAfastamento,
        protected string $dataInicio,
        protected string $dataRetorno,    
    ) {
        parent::__construct($idAtestado, $cid10, $textoPrincipal, $idDocumentacao);
    }

    // Getters
    public function getDiasAfastamento(): int {
        return $this->diasAfastamento;
    }

    public function getDataInicio(): string {
        return $this->dataInicio;
    }

    public function getDataRetorno(): string {
        return $this->dataRetorno;
    }

    // Setters
    public function setDiasAfastamento(int $diasAfastamento): void {
        $this->diasAfastamento = $diasAfastamento;
    }

    public function setDataInicio(string $dataInicio): void {
        $this->dataInicio = $dataInicio;
    }

    public function setDataRetorno(string $dataRetorno): void {
        $this->dataRetorno = $dataRetorno;
    }
}
