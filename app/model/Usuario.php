<?php

namespace App\Models;

Class Usuario {
    protected $id;
    protected $nome;
    protected $email;
    protected $senha;
    protected $tipo;

    public function __construct($nome, $email, $senha, $tipo) {
        $this->nome = $nome;
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

$usuario = new Usuario('Teste', 'Teste@.com', '123', 'Secretário');
//var_dump($usuario);
