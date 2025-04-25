<?php

namespace App\Models;

Class Atestado {
    public function __construct(
        private string $cid10,
        private string $textoPrincipal,
    ){}
}