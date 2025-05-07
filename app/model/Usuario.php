<?php

require_once '../app/config/Database.php';
require_once 'Endereco.php';

class Usuario {
    public function __construct(
        private string $idUsuario = '',
        private string $nome = '',
        private string $cpf = '',
        private string $telefone = '',
        private string $dataNascimento = '',
        private string $sexo = '',
        private string $email = '',
        private string $senha = '',
        private string $tipo = '',
        private ?Endereco $endereco = null // Correção para Endereco ser opcional
    ) {}

    public function autenticar($cpf, $senha) {
        try {
            $conexao = new PDO("mysql:host=localhost;dbname=medease", "root", "");
    
            $query = $conexao->prepare("SELECT * FROM usuarios WHERE cpf = :cpf AND senha = :senha");
            $query->bindParam(':cpf', $cpf);
            $query->bindParam(':senha', $senha);
            $query->execute();
    
            if ($query->rowCount() === 1) {
                $usuario = $query->fetch(PDO::FETCH_ASSOC);
    
                // Como a senha já foi verificada na query, não precisa de password_verify
                $this->nome = $usuario['nome'];
                $this->cpf = $usuario['cpf'];
                $this->telefone = $usuario['telefone'];
                $this->dataNascimento = $usuario['data_nascimento'];
                $this->sexo = $usuario['sexo'];
                $this->email = $usuario['email'];
                $this->senha = $usuario['senha'];
    
                return true;
            }
    
            return false;
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
            return false;
        }
    }
    

    // Getters e Setters
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

    public function setTipo($tipo): void {
        $this->tipo = $tipo;
    }

    public function setEndereco(Endereco $endereco): void {
        $this->endereco = $endereco;
    }
}
?>

