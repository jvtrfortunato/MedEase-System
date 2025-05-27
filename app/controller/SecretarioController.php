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

                // Criar objeto Endereco
                $endereco = new Endereco($rua, $numero, $bairro, $cidade, $estado, $cep, null);

                // Salvar médico com endereço
                $secretario->salvar($this->conn, $endereco);
                
                session_start();
                $_SESSION['mensagem'] = "Secretário cadastrado com sucesso!";
                header("Location: ../views/cadastrar-secretario.php");
                exit;

            } catch (PDOException $e) {
                echo "Erro ao cadastrar secretário: " . $e->getMessage();
            }
        }
    }


    public function exibirDados() {
        // Conexão
        $conn = $this->conn;

        // Criar instância fictícia de secretario só para listar
        $secretarioModel = new Secretario(0, '', '', '', '', '', '', '');

        // Chamada dos métodos com conexão
        return $secretarioModel->listarSecretarios($conn);
    }

    public function dadosSecretario($idSecretario){

        $secretario = Secretario::buscarSecretario($this->conn, $idSecretario);

        if($secretario){
            return $secretario;
        }

        return null;
    }
}

?>
