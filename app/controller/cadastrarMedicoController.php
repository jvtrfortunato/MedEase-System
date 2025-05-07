<?php

require_once '../model/Medico.php';
require_once '../model/Endereco.php';
require_once '../config/Database.php';

class MedicosController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recebe dados do formulário
            $nome = $_POST['nome'] ?? '';
            $cpf = $_POST['cpf'] ?? '';
            $telefone = $_POST['telefone'] ?? '';
            $dataNascimento = $_POST['dataNascimento'] ?? '';
            $sexo = $_POST['sexo'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $senhaRepetir = $_POST['senha-repetir'] ?? '';
            $tipo = 'medico';
            $crm = $_POST['crm'] ?? '';
            $especialidade = $_POST['especialidade'] ?? '';

            // Endereço
            $rua = $_POST['rua'] ?? '';
            $numero = $_POST['numero'] ?? '';
            $bairro = $_POST['bairro'] ?? '';
            $cidade = $_POST['cidade'] ?? '';
            $estado = $_POST['estado'] ?? '';
            $cep = $_POST['cep'] ?? '';

            // Verificação de campos vazios
            if (
                empty($nome) || empty($cpf) || empty($telefone) || empty($dataNascimento) || empty($sexo) ||
                empty($email) || empty($senha) || empty($senhaRepetir) || empty($crm) || empty($especialidade) ||
                empty($rua) || empty($numero) || empty($bairro) || empty($cidade) || empty($estado) || empty($cep)
            ) {
                echo "Erro: Todos os campos são obrigatórios!";
                return;
            }

            // Verificação de senha
            if ($senha !== $senhaRepetir) {
                echo "Erro: As senhas não coincidem.";
                return;
            }

            try {
                // Inserir endereço
                $sqlEndereco = "INSERT INTO enderecos (rua, numero, bairro, cidade, estado, cep)
                                VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sqlEndereco);
                $stmt->execute([$rua, $numero, $bairro, $cidade, $estado, $cep]);
                $idEndereco = $this->conn->lastInsertId();

                // Inserir usuário
                $sqlUsuario = "INSERT INTO usuarios (nome, cpf, telefone, data_nascimento, sexo, email, senha, tipo)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sqlUsuario);
                $stmt->execute([$nome, $cpf, $telefone, $dataNascimento, $sexo, $email, $senha, $tipo]);
                $idUsuario = $this->conn->lastInsertId();

                // Inserir médico
                $sqlMedico = "INSERT INTO medicos (crm, especialidade, id_usuario)
                              VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($sqlMedico);
                $stmt->execute([$crm, $especialidade, $idUsuario]);

                echo "Médico cadastrado com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao cadastrar médico: " . $e->getMessage();
            }
        }
    }
}

// Executar cadastro
$controller = new MedicosController();
$controller->cadastrar();

?>
