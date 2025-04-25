<?php

namespace App\Models;

require_once 'Atestado.php';

class Afastamento extends Atestado {
    public function __construct(
        string $cid10,
        string $textoPrincipal,

        protected int $diasAfastamento,
        protected string $dataInicio,
        protected string $dataRetorno
    ){}
}