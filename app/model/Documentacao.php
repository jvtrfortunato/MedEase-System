<?php

namespace App\Models;

class Documentacao {
    public function __construct(
        private int $idDocumentacao,
        private string $termosConsentimento,
        private Atestado $atestado,
        private string $declaracoesSaude,
        private int $idProntuario
    ) {}
}