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

    public function salvarMedico() {
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


                header("Location: ../views/gerenciar-profissionais.php");
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

    public function dadosMedico($idMedico) {
        $medico = Medico::buscarMedico($this->conn, $idMedico);

        if ($medico) {
            return $medico; // <-- Retorna o objeto diretamente, sem toArray()
        }

        return null;
    }

    public function excluirMedico($id_medico) {
        // Verifica se existem consultas associadas
        $sqlConsultas = "SELECT COUNT(*) as total FROM consultas WHERE id_medico = :id_medico";
        $stmtConsultas = $this->conn->prepare($sqlConsultas);
        $stmtConsultas->bindParam(":id_medico", $id_medico, PDO::PARAM_INT);
        $stmtConsultas->execute();
        $consultas = $stmtConsultas->fetch(PDO::FETCH_ASSOC)['total'];

        // Verifica se existem prontuários associados
        $sqlProntuarios = "SELECT COUNT(*) as total FROM prontuarios WHERE id_medico = :id_medico";
        $stmtProntuarios = $this->conn->prepare($sqlProntuarios);
        $stmtProntuarios->bindParam(":id_medico", $id_medico, PDO::PARAM_INT);
        $stmtProntuarios->execute();
        $prontuarios = $stmtProntuarios->fetch(PDO::FETCH_ASSOC)['total'];

        // Se houver qualquer relação, impede exclusão
        if ($consultas > 0 || $prontuarios > 0) {
            echo "<script>
                alert('Não é possível excluir: este médico possui consultas ou prontuários vinculados.');
                window.location.href='../views/gerenciar-profissionais.php';
            </script>";
            return;
        }

        // 1. Buscar o id_usuario associado ao id_medico
        $sqlBuscaUsuario = "SELECT id_usuario FROM medicos WHERE id_medico = :id_medico";
        $stmtBuscaUsuario = $this->conn->prepare($sqlBuscaUsuario);
        $stmtBuscaUsuario->bindParam(":id_medico", $id_medico, PDO::PARAM_INT);
        $stmtBuscaUsuario->execute();
        $id_usuario = $stmtBuscaUsuario->fetchColumn(); // retorna só o valor da coluna

        if ($id_usuario) {
            // 2. Deleta o Médico
            $sqlMedico = "DELETE FROM medicos WHERE id_medico = :id_medico";
            $stmtMedico = $this->conn->prepare($sqlMedico);
            $stmtMedico->bindParam(":id_medico", $id_medico, PDO::PARAM_INT);
            $stmtMedico->execute();

            // 3. Deleta o Endereço
            $sqlEndereco = "DELETE FROM enderecos WHERE id_usuario = :id_usuario";
            $stmtEndereco = $this->conn->prepare($sqlEndereco);
            $stmtEndereco->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmtEndereco->execute();

            // 4. Deleta o Usuário
            $sqlUsuario = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
            $stmtUsuario = $this->conn->prepare($sqlUsuario);
            $stmtUsuario->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmtUsuario->execute();
        }

        // 5. Redireciona para a tela de gerenciamento
        header("Location: ../views/gerenciar-profissionais.php");
        exit();
    }

    public function atualizarMedico($dados) {
        //Atualiza os dados na tabela usuarios
        $sqlMedico = "UPDATE usuarios 
                SET nome = :nome, 
                    cpf = :cpf,
                    telefone = :telefone,
                    data_nascimento = :data_nascimento,
                    sexo = :sexo,
                    email = :email,
                    senha = :senha
                WHERE id_usuario = :id_usuario";
        
        $stmtMedico = $this->conn->prepare($sqlMedico);
        $stmtMedico->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
        $stmtMedico->bindParam(":cpf", $dados['cpf'], PDO::PARAM_STR);
        $stmtMedico->bindParam(":telefone", $dados['telefone'], PDO::PARAM_STR);
        $stmtMedico->bindParam(":data_nascimento", $dados['dataNascimento'], PDO::PARAM_STR);
        $stmtMedico->bindParam(":sexo", $dados['sexo'], PDO::PARAM_STR);
        $stmtMedico->bindParam(":email", $dados['email'], PDO::PARAM_STR);
        $stmtMedico->bindParam(":senha", $dados['senha'], PDO::PARAM_STR);
        $stmtMedico->bindParam(":id_usuario", $dados['idUsuario'], PDO::PARAM_STR);
        $stmtMedico->execute(); // Linha 187

        //Atualiza os dados na tabela medicos
        $sqlMedico = "UPDATE medicos 
                SET crm = :crm, 
                    especialidade = :especialidade
                WHERE id_usuario = :id_usuario";
        
        $stmtMedico = $this->conn->prepare($sqlMedico);
        $stmtMedico->bindParam(":crm", $dados['crm'], PDO::PARAM_STR);
        $stmtMedico->bindParam(":especialidade", $dados['especialidade'], PDO::PARAM_STR);
        $stmtMedico->bindParam(":id_usuario", $dados['idUsuario'], PDO::PARAM_STR);
        $stmtMedico->execute();

        //Atualiza o endereço do medico
        $sqlEndereco = "UPDATE enderecos 
                SET rua = :rua, 
                    numero = :numero,
                    bairro = :bairro,
                    cidade = :cidade,
                    estado = :estado,
                    cep = :cep
                WHERE id_usuario = :id_usuario";

        $stmtEndereco = $this->conn->prepare($sqlEndereco);
        $stmtEndereco->bindParam(":rua", $dados['rua'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":numero", $dados['numero'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":bairro", $dados['bairro'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":cidade", $dados['cidade'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":estado", $dados['estado'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":cep", $dados['cep'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":id_usuario", $dados['idUsuario'], PDO::PARAM_INT);

        if ($stmtEndereco->execute()) {
            header("Location: ../views/gerenciar-profissionais.php?status=sucesso");
            exit;
        } else {
            echo "<script>alert('Erro ao editar os dados do paciente.'); history.back();</script>";
        }
    }

    public function buscarPorNome($nome) {

        return Medico::buscarPorNome($this->conn, $nome);
    }


}


