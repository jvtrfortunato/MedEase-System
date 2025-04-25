<?php

namespace App\Models;

require_once 'Endereco.php';

Class Usuario {
    public function __construct(
        private int $id,
        private string $nome,
        private string $cpf,
        private array $telefone = [],
        private Endereco $endereco,
        private string $dataNascimento,
        private string $sexo,
        private string $email,
        private string $senha,
        ) {
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

//$usuario = new Usuario(1,'a','1','1','1','1','1');
//var_dump($usuario);
