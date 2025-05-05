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

    // Getters
    public function getIdUsuario(): int {
        return $this->idUsuario;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getCpf(): string {
        return $this->cpf;
    }
    
    public function getTelefone(): string {
        return $this->telefone;
    }

    public function getDataNascimento(): string {
        return $this->dataNascimento;
    }

    public function getSexo(): string {
        return $this->sexo;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getSenha(): string {
        return $this->senha;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function getEndereco(): Endereco {
        return $this->endereco;
    }
    
    // Setters
    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setCpf($cpf): void {
        $this->cpf = $cpf;
    }  

    public function setTelefone($telefone): void {
        $this->telefone = $telefone;
    } 

    public function setDataNascimento($dataNascimento): void {
        $this->dataNascimento = $dataNascimento;
    } 

    public function setSexo($sexo): void {
        $this->sexo = $sexo;
    } 

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setSenha($senha): void {
        $this->senha = $senha;
    } 

    public function setTipo(): void {
        $this->tipo = $tipo;
    }

    public function setEndereco($endereco): void {
        $this->endereco = $endereco;
    } 
}

//$usuario = new Usuario(1,'a','1','1','1','1','1');
//var_dump($usuario);
