<?php

namespace App\Models;

class Endereco {
    public function __construct(
        private string $rua,
        private int $numero,
        private string $bairro,
        private string $cidade,
        private string $estado,
        private string $cep,
    ) {
    }

    public function getEnderecoCompleto(): string {
        return "Endereço completo formatado.";
    }
}

//$endereco = new Endereco("Rua das Flores", 123, "Centro", "São Paulo", "SP", "01010-000");
//var_dump($endereco);
