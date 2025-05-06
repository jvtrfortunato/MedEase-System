<?php

namespace App\Models;

Class Atestado {
    public function __construct(
        private int $idAtestado,
        private string $cid10,
        private string $textoPrincipal,
        private int $idDocumentacao
    ){}
}