<?php

require_once __DIR__ . '/../model/Paciente.php';
require_once __DIR__ . '/../model/Endereco.php';
require_once __DIR__ . '/../config/Database.php';

class PacienteController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function salvarPaciente() {

        session_start();

        // 1. Capturar os dados do formulário via POST
        $nome = $_POST['nome'];
        $dataNascimento = $_POST['dataNascimento'];
        $sexo = $_POST['sexo'];
        $estadoCivil = $_POST['estadoCivil'];
        $cpf = $_POST['cpf'];
        $rg = $_POST['rg'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $nomeResponsavel = $_POST['nomeResponsavel'];
        $cns = $_POST['cns'];
        $convenio = $_POST['convenio'];
        $planoSaude = $_POST['planoSaude'];

        // Endereço
        $rua = $_POST['rua'];
        $numero = $_POST['numero'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $cep = $_POST['cep'];

        // Verificar campos vazios
            if (empty($nome) || empty($cpf)) {
                echo "Erro: Insira pelo menos o nome completo e o CPF!";
                return;
            }

        try {
            // 2. Inserir o paciente no banco
            $stmtPaciente = $this->conn->prepare("INSERT INTO pacientes (nome, data_nascimento, sexo, estado_civil, cpf, rg, telefone, email, nome_responsavel, cns, convenio, plano_saude)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtPaciente->execute([$nome, $dataNascimento, $sexo, $estadoCivil, $cpf, $rg, $telefone, $email, $nomeResponsavel, $cns, $convenio, $planoSaude]);

            // 3. Recuperar o ID do paciente recém-inserido
            $idPaciente = $this->conn->lastInsertId();

            // 4. Criar objeto Endereco com idPaciente
            $endereco = new Endereco($rua, $numero, $bairro, $cidade, $estado, $cep, null, $idPaciente);

            // 5. Inserir o endereço no banco
            $stmtEndereco = $this->conn->prepare("INSERT INTO enderecos (rua, numero, bairro, cidade, estado, cep, id_paciente)
                                            VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtEndereco->execute([
                $endereco->getRua(),
                $endereco->getNumero(),
                $endereco->getBairro(),
                $endereco->getCidade(),
                $endereco->getEstado(),
                $endereco->getCep(),
                $endereco->getIdPaciente()
            ]);

            if ($_SESSION['usuario_tipo'] === 'secretario') {

                header("Location: ../views/gerenciar-pacientes-secretario.php");
                exit;

            } 
            
            if ($_SESSION['usuario_tipo'] === 'administrador') {

                header("Location: ../views/gerenciar-pacientes.php");
                exit;
            }

        } catch (PDOException $e) {
            echo "Erro ao cadastrar paciente: " . $e->getMessage();
        }
    }

    public function listarPacientes(): array {
        $query = "
        SELECT 
            p.*, 
            e.*,  
            e.id_paciente AS endereco_id_paciente
        FROM pacientes p
        JOIN enderecos e ON p.id_paciente = e.id_paciente
        ORDER BY p.nome ASC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pacientes = [];

        foreach ($result as $row) {
            $endereco = new Endereco(
                $row['rua'], $row['numero'], $row['bairro'], $row['cidade'], 
                $row['estado'], $row['cep'], $row['id_usuario'], $row['id_paciente']
            );

            $paciente = new Paciente(
                $row['id_paciente'], $row['nome'], $row['data_nascimento'], $row['sexo'],
                $row['estado_civil'], $row['cpf'], $row['rg'], $row['telefone'],
                $row['email'], $row['nome_responsavel'], $row['cns'],
                $row['convenio'], $row['plano_saude'], $endereco
            );

            $pacientes[] = $paciente;
        }

        return $pacientes;
    }

    public function buscarPacienteCompleto(int $id): ?Paciente {
        // Busca o paciente
        $sqlPaciente = "SELECT * FROM pacientes WHERE id_paciente = :id";
        $stmtPaciente = $this->conn->prepare($sqlPaciente);
        $stmtPaciente->execute([':id' => $id]);
        $dataPaciente = $stmtPaciente->fetch(PDO::FETCH_ASSOC);

        if (!$dataPaciente) {
            return null;
        }

        // Busca o endereço
        $sqlEndereco = "SELECT * FROM enderecos WHERE id_paciente = :id";
        $stmtEndereco = $this->conn->prepare($sqlEndereco);
        $stmtEndereco->execute([':id' => $id]);
        $dataEndereco = $stmtEndereco->fetch(PDO::FETCH_ASSOC);

        $endereco = null;
        if ($dataEndereco) {
            $endereco = new Endereco(
                $dataEndereco['rua'],
                $dataEndereco['numero'],
                $dataEndereco['bairro'],
                $dataEndereco['cidade'],
                $dataEndereco['estado'],
                $dataEndereco['cep'],
                $dataEndereco['id_usuario'] ?? null,
                $id
            );
        }

        return new Paciente(
            $dataPaciente['id_paciente'],
            $dataPaciente['nome'],
            $dataPaciente['data_nascimento'],
            $dataPaciente['sexo'],
            $dataPaciente['estado_civil'],
            $dataPaciente['cpf'],
            $dataPaciente['rg'],
            $dataPaciente['telefone'],
            $dataPaciente['email'],
            $dataPaciente['nome_responsavel'],
            $dataPaciente['cns'],
            $dataPaciente['convenio'],
            $dataPaciente['plano_saude'],
            $endereco
        );
    }

    public function excluirPaciente($id_paciente) {
        // Verifica se existem consultas associadas
        $sqlConsultas = "SELECT COUNT(*) as total FROM consultas WHERE id_paciente = :id_paciente";
        $stmtConsultas = $this->conn->prepare($sqlConsultas);
        $stmtConsultas->bindParam(":id_paciente", $id_paciente, PDO::PARAM_INT);
        $stmtConsultas->execute();
        $consultas = $stmtConsultas->fetch(PDO::FETCH_ASSOC)['total'];

        // Verifica se existem prontuários associados
        $sqlProntuarios = "SELECT COUNT(*) as total FROM prontuarios WHERE id_paciente = :id_paciente";
        $stmtProntuarios = $this->conn->prepare($sqlProntuarios);
        $stmtProntuarios->bindParam(":id_paciente", $id_paciente, PDO::PARAM_INT);
        $stmtProntuarios->execute();
        $prontuarios = $stmtProntuarios->fetch(PDO::FETCH_ASSOC)['total'];

        // Se houver qualquer relação, impede exclusão
        if ($consultas > 0 || $prontuarios > 0) {
            echo "<script>
                alert('Não é possível excluir: este paciente possui consultas ou prontuários vinculados.');
                window.location.href='../views/gerenciar-pacientes.php';
            </script>";
            return;
        }

        // Deleta o Endereço
        $sqlEndereco = "DELETE FROM enderecos WHERE id_paciente = :id_paciente";
        $stmtEndereco = $this->conn->prepare($sqlEndereco);
        $stmtEndereco->bindParam(":id_paciente", $id_paciente, PDO::PARAM_INT);
        $stmtEndereco->execute();

        // Deleta o Paciente
        $sqlPaciente = "DELETE FROM pacientes WHERE id_paciente = :id_paciente";
        $stmtPaciente = $this->conn->prepare($sqlPaciente);
        $stmtPaciente->bindParam(":id_paciente", $id_paciente, PDO::PARAM_INT);
        $stmtPaciente->execute();

        // Redireciona de volta para a view
        header("Location: ../views/gerenciar-pacientes.php");
        exit(); // sempre use exit() após um redirecionamento
    }

    public function atualizarPaciente($dados) {
        //Atualiza os dados do paciente
        $sqlPaciente = "UPDATE pacientes 
                SET nome = :nome, 
                    data_nascimento = :data_nascimento,
                    sexo = :sexo,
                    estado_civil = :estado_civil,
                    cpf = :cpf,
                    rg = :rg,
                    telefone = :telefone,
                    email = :email,
                    nome_responsavel = :nome_responsavel,
                    cns = :cns,
                    convenio = :convenio,
                    plano_saude = :plano_saude
                WHERE id_paciente = :id_paciente";
        
        $stmtPaciente = $this->conn->prepare($sqlPaciente);
        $stmtPaciente->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":data_nascimento", $dados['dataNascimento'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":sexo", $dados['sexo'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":estado_civil", $dados['estadoCivil'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":cpf", $dados['cpf'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":rg", $dados['rg'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":telefone", $dados['telefone'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":email", $dados['email'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":nome_responsavel", $dados['nomeResponsavel'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":cns", $dados['cns'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":convenio", $dados['convenio'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":plano_saude", $dados['numPlanoSaude'], PDO::PARAM_STR);
        $stmtPaciente->bindParam(":id_paciente", $dados['idPaciente'], PDO::PARAM_INT);
        $stmtPaciente->execute();

        //Atualiza o endereço do paciente
        $sqlEndereco = "UPDATE enderecos 
                SET rua = :rua, 
                    numero = :numero,
                    bairro = :bairro,
                    cidade = :cidade,
                    estado = :estado,
                    cep = :cep
                WHERE id_paciente = :id_paciente";

        $stmtEndereco = $this->conn->prepare($sqlEndereco);
        $stmtEndereco->bindParam(":rua", $dados['rua'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":numero", $dados['numero'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":bairro", $dados['bairro'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":cidade", $dados['cidade'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":estado", $dados['estado'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":cep", $dados['cep'], PDO::PARAM_STR);
        $stmtEndereco->bindParam(":id_paciente", $dados['idPaciente'], PDO::PARAM_INT);

        if ($stmtEndereco->execute()) {
            header("Location: ../views/gerenciar-pacientes.php?status=sucesso");
            exit;
        } else {
            echo "<script>alert('Erro ao editar os dados do paciente.'); history.back();</script>";
        }
    }
}
