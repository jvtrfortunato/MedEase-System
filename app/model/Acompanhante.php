<?php

namespace App\Models;

require_once 'Atestado.php';

class Acompanhante extends Atestado {
    public function __construct(
        string $cid10,
        string $textoPrincipal,

        protected string $nomeAcompanhante,
        protected string $cpfAcompanhante,
        protected string $parentescoAcompanhante, 
        protected string $data,
        protected string $horarioChegada,
        protected string $horarioSaida
    ){}
}