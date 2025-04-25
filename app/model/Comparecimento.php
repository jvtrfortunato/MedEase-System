<?php

namespace App\Models;

require_once 'Atestado.php';

class Comparecimento extends Atestado {
    public function __construct(
        string $cid10,
        string $textoPrincipal,

        protected string $data,
        protected string $horarioChegada,
        protected string $horarioSaida
    ){}
}