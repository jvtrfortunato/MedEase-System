<?php

namespace App\Models;

Class Usuario {
    private int $id;
    private string $nome;
    private string $cpf;
    private string $telefone;
    private string $email;
    private string $senha;
    private string $tipo;

    public function __construct($nome, $cpf, $telefone, $email, $senha, $tipo) {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        $this->tipo =  $tipo;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function setCpf($cpf): void {
        $this->cpf = $cpf;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone): void {
        $this->telefone = $telefone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function setTipo(): void {
        $this->tipo = $tipo;
    }

    public function verificarSenha($senha) {
        return password_verify($senha, $this->senha);
    }
}
