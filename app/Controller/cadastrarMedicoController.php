<?php

require_once '../model/Medico.php';
require_once '../model/Endereco.php';
require_once '../config/Database.php';

class MedicosController {
    private $conexao;

    public function __construct() {
        $database = new Database();
        $this->conexao = $database->conectar();
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recebe dados do formulário

            if ($_POST['senha'] !== $_POST['senha-repetir']) {
                echo "As senhas não coincidem.";
                return;
            } 
            
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $telefone = $_POST['telefone'];
            $dataNascimento = $_POST['dataNascimento'];
            $sexo = $_POST['sexo'];
            $email = $_POST['email'];           
            $senha = $_POST['senha'];
            $tipo = 'medico';
            $crm = $_POST['crm'];
            $especialidade = $_POST['especialidade'];

            // Endereço
            $rua = $_POST['rua'];
            $numero = $_POST['numero'];
            $bairro = $_POST['bairro'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];
            $cep = $_POST['cep'];

            // Cria objeto Endereco
            $endereco = new Endereco(0, $rua, $numero, $bairro, $cidade, $estado, $cep);

            try {
                // Salva endereço
                $sqlEndereco = "INSERT INTO enderecos (rua, numero, bairro, cidade, estado, cep)
                                VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->conexao->prepare($sqlEndereco);
                $stmt->execute([$rua, $numero, $bairro, $cidade, $estado, $cep]);

                $idEndereco = $this->conexao->lastInsertId();

                // 1. Inserir usuário
                $sqlUsuario = "INSERT INTO usuarios (nome, cpf, telefone, data_nascimento, sexo, email, senha, tipo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conexao->prepare($sqlUsuario);
                $stmt->execute([$nome, $cpf, $telefone, $dataNascimento, $sexo, $email, $senha, $tipo]);

                $idUsuario = $this->conexao->lastInsertId(); // pega o ID gerado

                // 2. Inserir médico
                $sqlMedico = "INSERT INTO medicos (crm, especialidade, id_usuario)
                VALUES (?, ?, ?)";
                $stmt = $this->conexao->prepare($sqlMedico);
                $stmt->execute([$crm, $especialidade, $idUsuario]);


                echo "Médico cadastrado com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao cadastrar médico: " . $e->getMessage();
            }
        }
    }
}

// Executa o cadastro
$controller = new MedicosController();
$controller->cadastrar();


?>   