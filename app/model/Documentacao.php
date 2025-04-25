<?php

namespace App\Models;

class Documentacao {
    public function __construct(
        private string $termosConsentimento,
        private Atestado $atestado,
        private string $declaracoesSaude
    ) {}
}