<?php

namespace App\Models;

class Exame {
    public function __construct(
        private int $idMedico,
        private string $nomeExame,
        private string $nomeClinica
    ){}
}