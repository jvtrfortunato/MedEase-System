<?php

namespace App\Models;

class Exame {
    public function __construct(
        private int $idExame,
        private string $nomeExame,
        private int $idProntuario
    ){}
}