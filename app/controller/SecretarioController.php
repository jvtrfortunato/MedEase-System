<?php

require_once '../model/Secretario.php';
require_once '../model/Endereco.php';
require_once '../config/Database.php';

class SecretarioController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recebendo dados do formulário
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $telefone = $_POST['telefone'];
            $dataNascimento = $_POST['dataNascimento'];
            $sexo = $_POST['sexo'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $senhaRepetir = $_POST['senha-repetir'];

            $rua = $_POST['rua'];
            $numero = $_POST['numero'];
            $bairro = $_POST['bairro'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];
            $cep = $_POST['cep'];

            // Verificações
            if (
                empty($nome) || empty($cpf) || empty($telefone) || empty($dataNascimento) ||
                empty($sexo) || empty($email) || empty($senha) || empty($senhaRepetir) ||
                empty($rua) || empty($numero) || empty($bairro) ||
                empty($cidade) || empty($estado) || empty($cep)
            ) {
                echo "Erro: Todos os campos são obrigatórios!";
                return;
            }

            if ($senha !== $senhaRepetir) {
                echo "Erro: As senhas não coincidem.";
                return;
            }

            try {

                //Criar objeto Secretario
                $secretario = new Secretario(
                    0,
                    $nome,
                    $cpf,
                    $telefone,
                    $dataNascimento,
                    $sexo,
                    $email,
                    $senha
                );

                // Inserir usuário no banco
                $sqlUsuario = "INSERT INTO usuarios (nome, cpf, telefone, data_nascimento, sexo, email, senha, tipo)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sqlUsuario);
                $stmt->execute([
                    $secretario->getNome(),
                    $secretario->getCpf(),
                    $secretario->getTelefone(),
                    $secretario->getDataNascimento(),
                    $secretario->getSexo(),
                    $secretario->getEmail(),
                    $secretario->getSenha(),
                    $secretario->getTipo()
                ]);

                $idUsuario = $this->conn->lastInsertId();

                // Inserir dados específicos de secretário
                $sqlSecretario = "INSERT INTO secretarios (id_usuario) VALUES (?)";
                $stmt = $this->conn->prepare($sqlSecretario);
                $stmt->execute([$idUsuario]);

                $idSecretario = $idUsuario;

                // Criar objeto Endereco
                $endereco = new Endereco($rua, $numero, $bairro, $cidade, $estado, $cep, $idSecretario, null);

                // Inserir Endereço no banco
                $sqlEndereco = "INSERT INTO enderecos (rua, numero, bairro, cidade, estado, cep, id_usuario)
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sqlEndereco);
                $stmt->execute([
                    $endereco->getRua(),
                    $endereco->getNumero(),
                    $endereco->getBairro(),
                    $endereco->getCidade(),
                    $endereco->getEstado(),
                    $endereco->getCep(),
                    $idSecretario
                ]);

                echo "Secretário cadastrado com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao cadastrar secretário: " . $e->getMessage();
            }
        }
    }
}

// Executar cadastro
$controller = new SecretarioController();
$controller->cadastrar();

?>
