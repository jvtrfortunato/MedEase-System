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

    public function salvarSecretario() {
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
                // Criar objeto Endereco (sem id_usuario ainda)
                $endereco = new Endereco($rua, $numero, $bairro, $cidade, $estado, $cep);

                //Criar objeto Secretario
                $secretario = new Secretario(
                    0,
                    $nome,
                    $cpf,
                    $telefone,
                    $dataNascimento,
                    $sexo,
                    $email,
                    $senha,
                    $endereco
                );

                // Salvar médico com endereço
                $secretario->salvar($this->conn, $endereco);
                
                header("Location: ../views/gerenciar-profissionais.php");
                exit;

            } catch (PDOException $e) {
                echo "Erro ao cadastrar secretário: " . $e->getMessage();
            }
        }
    }


    public function exibirDados() {
        // Conexão
        $conn = $this->conn;

        $enderecoVazio = new Endereco('', '', '', '', '', '');

        // Criar instância fictícia de secretario só para listar
        $secretarioModel = new Secretario(0, '', '', '', '', '', '', '', $enderecoVazio);

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

    public function atualizarSecretario($dados) {
        //Atualiza os dados na tabela usuarios
        $sqlSecretario = "UPDATE usuarios 
                SET nome = :nome, 
                    cpf = :cpf,
                    telefone = :telefone,
                    data_nascimento = :data_nascimento,
                    sexo = :sexo,
                    email = :email,
                    senha = :senha
                WHERE id_usuario = :id_usuario";
        
        $stmtSecretario = $this->conn->prepare($sqlSecretario);
        $stmtSecretario->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
        $stmtSecretario->bindParam(":cpf", $dados['cpf'], PDO::PARAM_STR);
        $stmtSecretario->bindParam(":telefone", $dados['telefone'], PDO::PARAM_STR);
        $stmtSecretario->bindParam(":data_nascimento", $dados['dataNascimento'], PDO::PARAM_STR);
        $stmtSecretario->bindParam(":sexo", $dados['sexo'], PDO::PARAM_STR);
        $stmtSecretario->bindParam(":email", $dados['email'], PDO::PARAM_STR);
        $stmtSecretario->bindParam(":senha", $dados['senha'], PDO::PARAM_STR);
        $stmtSecretario->bindParam(":id_usuario", $dados['idUsuario'], PDO::PARAM_STR);
        $stmtSecretario->execute(); // Linha 187

        //Atualiza o endereço do secretário
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

    public function excluirSecretario($id_secretario) {
        // Verifica se existem consultas associadas
        $sqlConsultas = "SELECT COUNT(*) as total FROM consultas WHERE id_secretario = :id_secretario";
        $stmtConsultas = $this->conn->prepare($sqlConsultas);
        $stmtConsultas->bindParam(":id_secretario", $id_secretario, PDO::PARAM_INT);
        $stmtConsultas->execute();
        $consultas = $stmtConsultas->fetch(PDO::FETCH_ASSOC)['total'];

        // Se houver qualquer relação, impede exclusão
        if ($consultas > 0) {
            echo "<script>
                alert('Não é possível excluir: este secretário possui consultas vinculados.');
                window.location.href='../views/gerenciar-profissionais.php';
            </script>";
            return;
        }

        // 1. Buscar o id_usuario associado ao id_secretario
        $sqlBuscaUsuario = "SELECT id_usuario FROM secretarios WHERE id_secretario = :id_secretario";
        $stmtBuscaUsuario = $this->conn->prepare($sqlBuscaUsuario);
        $stmtBuscaUsuario->bindParam(":id_secretario", $id_secretario, PDO::PARAM_INT);
        $stmtBuscaUsuario->execute();
        $id_usuario = $stmtBuscaUsuario->fetchColumn(); // retorna só o valor da coluna

        if ($id_usuario) {
            // 2. Deleta o Secretário
            $sqlSecretario = "DELETE FROM secretarios WHERE id_secretario = :id_secretario";
            $stmtSecretario = $this->conn->prepare($sqlSecretario);
            $stmtSecretario->bindParam(":id_secretario", $id_secretario, PDO::PARAM_INT);
            $stmtSecretario->execute();

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

    public function buscarPorNome($nome) {

        return Secretario::buscarPorNome($this->conn, $nome); 
    }

}

?>
