<?php

namespace App\Models;

class Prescricao {
    public function __construct(
        //medicamento
        private string $medicamento,
        private string $concentracao,
        private string $formaFarmaceutica,
        private string $viaAdministracao,
        private string $tipoReceita,

        //posologia
        private string $dose,
        private string $frequenciaDose,

        //período de tratamento
        private string $inicio,
        private string $dias,

        //outros
        private string $recomendacoes
    ){}
}
