<?php

namespace App\Models;

class Endereco {
    public function __construct(
        private string $rua,
        private string $numero,
        private string $bairro,
        private string $cidade,
        private string $estado,
        private string $cep,
    ) {
    }

    public function getRua(): string {
        return $this->rua;
    }
    
    public function setRua($rua): void {
        $this->rua = $rua;
    }

    public function getNumero(): int {
        return $this->numero;
    }
    
    public function setNumero($numero): void {
        $this->numero = $numero;
    }

    public function getNome(): string {
        return $this->bairro;
    }
    
    public function setBairro($bairro): void {
        $this->bairro = $bairro;
    }

    public function getCidade(): string {
        return $this->cidade;
    }
    
    public function setNome($cidade): void {
        $this->cidade = $cidade;
    }

    public function getEstado(): string {
        return $this->estado;
    }
    
    public function setEstado($estado): void {
        $this->estado = $estado;
    }

    public function getCep(): string {
        return $this->cep;
    }
    
    public function setCep($cep): void {
        $this->cep = $cep;
    }

    public function getEnderecoCompleto(): string {
        return "Endereço completo formatado.";
    }
}

//$endereco = new Endereco("Rua das Flores", "123", "Centro", "São Paulo", "SP", "01010-000");
//var_dump($endereco);
