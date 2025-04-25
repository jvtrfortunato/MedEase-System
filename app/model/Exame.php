<?php

namespace App\Models;

class Exame {
    public function __construct(
        private string $nomeExame,
        private string $nomeClinica
    ){}
}