<?php

class Endereco {
    public function __construct(
        private string $rua,
        private string $numero,
        private string $bairro,
        private string $cidade,
        private string $estado,
        private string $cep
    ) {
    }

    // Getters
    public function getRua(): string {
        return $this->rua;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getBairro(): string {
        return $this->bairro;
    }

    public function getCidade(): string {
        return $this->cidade;
    }

    public function getEstado(): string {
        return $this->estado;
    }

    public function getCep(): string {
        return $this->cep;
    }

    // Setters
    public function setRua(string $rua): void {
        $this->rua = $rua;
    }
    
    public function setNumero(string $numero): void {
        $this->numero = $numero;
    }
    
    public function setBairro(string $bairro): void {
        $this->bairro = $bairro;
    }
    
    public function setCidade(string $cidade): void {
        $this->cidade = $cidade;
    }
    
    public function setEstado(string $estado): void {
        $this->estado = $estado;
    }
    
    public function setCep(string $cep): void {
        $this->cep = $cep;
    }
}

//$endereco = new Endereco("Rua das Flores", "123", "Centro", "São Paulo", "SP", "01010-000");
//var_dump($endereco);
