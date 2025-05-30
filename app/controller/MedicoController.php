<?php

require_once '../model/Usuario.php';
require_once '../model/Medico.php';
require_once '../model/Endereco.php';
require_once '../config/Database.php';

class MedicoController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Coletar e validar os dados do POST
            $nome = $_POST['nome'] ?? '';
            $cpf = $_POST['cpf'] ?? '';
            $telefone = $_POST['telefone'] ?? '';
            $dataNascimento = $_POST['dataNascimento'] ?? '';
            $sexo = $_POST['sexo'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $senhaRepetir = $_POST['senha-repetir'] ?? '';
            $crm = $_POST['crm'] ?? '';
            $especialidade = $_POST['especialidade'] ?? '';

            // Endereço
            $rua = $_POST['rua'] ?? '';
            $numero = $_POST['numero'] ?? '';
            $bairro = $_POST['bairro'] ?? '';
            $cidade = $_POST['cidade'] ?? '';
            $estado = $_POST['estado'] ?? '';
            $cep = $_POST['cep'] ?? '';

            // Validação básica
            if (
                empty($nome) || empty($cpf) || empty($telefone) || empty($dataNascimento) || empty($sexo) ||
                empty($email) || empty($senha) || empty($senhaRepetir) || empty($crm) || empty($especialidade) ||
                empty($rua) || empty($numero) || empty($bairro) || empty($cidade) || empty($estado) || empty($cep)
            ) {
                echo "Erro: Todos os campos são obrigatórios!";
                return;
            }

            if ($senha !== $senhaRepetir) {
                echo "Erro: As senhas não coincidem.";
                return;
            }

            try {
                // Criar objeto Endereco (sem id_usuario ainda)
                $endereco = new Endereco($rua, $numero, $bairro, $cidade, $estado, $cep);

                // Criar objeto Medico
                $medico = new Medico(
                    0,
                    $nome,
                    $cpf,
                    $telefone,
                    $dataNascimento,
                    $sexo,
                    $email,
                    $senha,
                    $crm,
                    $especialidade,
                    $endereco
                );

                

                // Salvar médico com endereço
                $medico->salvar($this->conn, $endereco);


                session_start();
                $_SESSION['mensagem'] = "Médico cadastrado com sucesso!";
                header("Location: ../views/cadastrar-medico.php");
                exit;

            } catch (PDOException $e) {
                echo "Erro ao cadastrar médico: " . $e->getMessage();
            }
        }
    }

    public function exibirDados() {
        // Conexão
        $conn = $this->conn;

        $enderecoVazio = new Endereco('', '', '', '', '', '');
        $medicoModel = new Medico(0, '', '', '', '', '', '', '', '', '', $enderecoVazio);

        // Chamada dos métodos com conexão
        return $medicoModel->listarMedicos($conn);
    }

    public function dadosMedico($idMedico)
    {
       $medico = Medico::buscarMedico($this->conn, $idMedico);

        if ($medico) {
            return $medico; // <-- Retorna o objeto diretamente, sem toArray()
        }


        return null;
    }
    

}


