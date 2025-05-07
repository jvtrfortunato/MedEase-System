<?php

require_once 'Atestado.php';

class AtestadoComparecimento extends Atestado {
    public function __construct(
        int $idAtestado,
        string $cid10,
        string $textoPrincipal,
        int $idDocumentacao,
        protected string $data,
        protected string $horarioChegada,
        protected string $horarioSaida
    ) {
        parent::__construct($idAtestado, $cid10, $textoPrincipal, $idDocumentacao);
    }
}