<?php

namespace App\Models;

class HistoricoMedico {
    public function __construct(
        private string $doencasPreexistentes,
        private string $medicacoesUsoContinuo,
        private string $cirurgiasAnteriores,
        private string $alergiasMedicamentos,
        private array $historicoDoencasFamilia
    ) {}
    
    // Getters e setters podem ser adicionados aqui
}