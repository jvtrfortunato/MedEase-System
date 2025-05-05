<?php

namespace App\Models;

class Internacao {
    public function __construct(
        private string $dataAdmissaoEAlta,
        private string $diagnosticoInternacao,
        private string $procedimentosCirurgicos,
        private string $medicosResponsaveis,
        private int $idProntuario
    ) {}
}