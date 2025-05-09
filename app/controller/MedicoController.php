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
    
            // Verificar campos vazios
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
    
            // Criar objeto Medico
            $medico = new Medico(
                0, // ID do usuário ainda não gerado
                $nome,
                $cpf,
                $telefone,
                $dataNascimento,
                $sexo,
                $email,
                $senha,
                $crm,
                $especialidade
            );
            

            try {
    
                // Inserir Usuário
                $sqlUsuario = "INSERT INTO usuarios (nome, cpf, telefone, data_nascimento, sexo, email, senha, tipo)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sqlUsuario);
                $stmt->execute([
                    $medico->getNome(),
                    $medico->getCpf(),
                    $medico->getTelefone(),
                    $medico->getDataNascimento(),
                    $medico->getSexo(),
                    $medico->getEmail(),
                    $medico->getSenha(),
                    $medico->getTipo(),
                ]);
                $idUsuario = $this->conn->lastInsertId();
    
                // Inserir Médico
                $sqlMedico = "INSERT INTO medicos (crm, especialidade, id_usuario)
                              VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($sqlMedico);
                $stmt->execute([
                    $medico->getCrm(),
                    $medico->getEspecialidade(),
                    $idUsuario
                ]);

                // Recuperar o ID do medico recém-inserido
                $idMedico = $idUsuario;
            
                
                // Criar objeto Endereco
                $endereco = new Endereco($rua, $numero, $bairro, $cidade, $estado, $cep, $idMedico, null);
                
                // Inserir Endereço
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
                    $idMedico
                ]);

                echo "Médico cadastrado com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao cadastrar médico: " . $e->getMessage();
            }
        }
    }
}

// Executar cadastro
$controller = new MedicoController();
$controller->cadastrar();

?>
