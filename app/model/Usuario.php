<?php

namespace App\Models;

require_once 'Endereco.php';

Class Usuario {
    public function __construct(
        private int $idUsuario,
        private string $nome,
        private string $cpf,
        private string $telefone,
        private string $dataNascimento,
        private string $sexo,
        private string $email,
        private string $senha,
        private string $tipo,
        private Endereco $endereco
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
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setCpf(string $cpf): void {
        $this->cpf = $cpf;
    }  

    public function setTelefone(string $telefone): void {
        $this->telefone = $telefone;
    } 

    public function setDataNascimento(string $dataNascimento): void {
        $this->dataNascimento = $dataNascimento;
    } 

    public function setSexo(string $sexo): void {
        $this->sexo = $sexo;
    } 

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setSenha(string $senha): void {
        $this->senha = $senha;
    } 

    public function setTipo(string $tipo): void {
        $this->tipo = $tipo;
    }

    public function setEndereco(Endereco $endereco): void {
        $this->endereco = $endereco;
    } 
}

//$usuario = new Usuario(1,'a','1','1','1','1','1');
//var_dump($usuario);
