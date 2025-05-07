<?php

require_once '../model/Secretario.php';
require_once '../model/Endereco.php';
require_once '../config/Database.php';

class SecretariosController {
    private $conexao;

    public function __construct() {
        $database = new Database();
        $this->conexao = $database->conectar();
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Dados pessoais
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $telefone = $_POST['telefone'];
            $dataNascimento = $_POST['dataNascimento'];
            $sexo = $_POST['sexo'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $tipo = 'secretario';

            // Endereço
            $rua = $_POST['rua'];
            $numero = $_POST['numero'];
            $bairro = $_POST['bairro'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];
            $cep = $_POST['cep'];

            try {
                // Inserir endereço
                $sqlEndereco = "INSERT INTO enderecos (rua, numero, bairro, cidade, estado, cep)
                                VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->conexao->prepare($sqlEndereco);
                $stmt->execute([$rua, $numero, $bairro, $cidade, $estado, $cep]);
                $idEndereco = $this->conexao->lastInsertId();

                // Inserir usuário
                $sqlUsuario = "INSERT INTO usuarios (nome, cpf, telefone, data_nascimento, sexo, email, senha, tipo)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conexao->prepare($sqlUsuario);
                $stmt->execute([
                    $nome, $cpf, $telefone, $dataNascimento, $sexo, $email, $senha, $tipo
                ]);
                $idUsuario = $this->conexao->lastInsertId();

                // Inserir secretário
                $sqlSecretario = "INSERT INTO secretarios (id_usuario) VALUES (?)";
                $stmt = $this->conexao->prepare($sqlSecretario);
                $stmt->execute([$idUsuario]);

                echo "Secretário cadastrado com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao cadastrar secretário: " . $e->getMessage();
            }
        }
    }
}

// Executar cadastro
$controller = new SecretariosController();
$controller->cadastrar();

?>
