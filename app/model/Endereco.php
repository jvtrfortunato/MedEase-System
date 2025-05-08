<?php

class Endereco {
    public function __construct(
        private string $rua,
        private string $numero,
        private string $bairro,
        private string $cidade,
        private string $estado,
        private string $cep,
        private ?int $idUsuario = null,
        private ?int $idPaciente = null
    ) {
    }

    // Getters
    public function getRua(): string { return $this->rua; }
    public function getNumero(): string { return $this->numero; }
    public function getBairro(): string { return $this->bairro; }
    public function getCidade(): string { return $this->cidade; }
    public function getEstado(): string { return $this->estado; }
    public function getCep(): string { return $this->cep; }
    public function getIdUsuario(): ?int { return $this->idUsuario; }
    public function getIdPaciente(): ?int { return $this->idPaciente; }

    // Setters
    public function setRua(string $rua): void { $this->rua = $rua; }
    public function setNumero(string $numero): void { $this->numero = $numero; }
    public function setBairro(string $bairro): void { $this->bairro = $bairro; }
    public function setCidade(string $cidade): void { $this->cidade = $cidade; }
    public function setEstado(string $estado): void { $this->estado = $estado; }
    public function setCep(string $cep): void { $this->cep = $cep; }
    public function setIdUsuario(?int $idUsuario): void { $this->idUsuario = $idUsuario; }
    public function setIdPaciente(?int $idPaciente): void { $this->idPaciente = $idPaciente; }
}
