<?php

namespace App\Models;

require_once 'Endereco.php';

class Paciente {
    public function __construct(
        private int $id,
        private string $nome,
        private string $cpf,
        private string $dataNascimento,
        private Endereco $endereco,
        private array $telefone = [],
        private string $email,
        private string $planoSaude
    ) {}    
    
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
    
    public function getDataNascimento(): string {
        return $this->dataNascimento;
    }
    
    public function setDataNascimento($dataNascimento): void {
        $this->dataNascimento = $dataNascimento;
    }
    
    public function getEndereco(): Endereco { Talvez esse get e set tem que estar na classe Endereco
        return $this->endereco;
    }
    
    public function setEndereco($endereco): void {
        $this->endereco = $endereco;
    }
    
    public function getTelefone(): string {
        return $this->telefone;
    }
    
    public function setTelefone($telefone): void {
        $this->telefone = $telefone;
    }
    
    public function getEmail(): string {
        return $this->email;
    }
    
    public function setEmail($email): void {
        $this->email = $email;
    }
    
    public function getPlanoSaude(): string {
        return $this->planoSaude;
    }
    
    public function setPlanoSaude($planoSaude): void {
        $this->planoSaude = $planoSaude;
    }
}

/*$endereco = new Endereco(
    "Rua das Flores", 
    123, 
    "Centro", 
    "São Paulo", 
    "SP", 
    "01010-000");

$paciente = new Paciente(
    1,
    'Paciente Teste', 
    '999.999.999-99', 
    '99/99/9999', 
    $endereco, 
    ['(99)99999-9999'], 
    'Paciente@.com', 
    'UniMed');

var_dump($paciente);*/
