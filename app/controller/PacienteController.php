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

            echo "Paciente e endereço cadastrados com sucesso!";

        } catch (PDOException $e) {
            echo "Erro ao cadastrar paciente: " . $e->getMessage();
        }
    }

    public function listarPacientes(): array {
    $query = "SELECT * FROM paciente";
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
}
