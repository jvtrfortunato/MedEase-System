<?php

require_once 'models/Paciente.php';
require_once 'models/Endereco.php';
require_once 'config/Database.php';

class PacienteController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function salvar(Paciente $paciente): bool {
        $sql = "INSERT INTO pacientes (nome, data_nascimento, sexo, estado_civil, cpf, rg, telefone, email, nome_responsavel, cns, convenio, plano_saude) 
                VALUES (:nome, :data_nascimento, :sexo, :estado_civil, :cpf, :rg, :telefone, :email, :nome_responsavel, :cns, :convenio, :plano_saude)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nome' => $paciente->getNome(),
            ':data_nascimento' => $paciente->getDataNascimento(),
            ':sexo' => $paciente->getSexo(),
            ':estado_civil' => $paciente->getEstadoCivil(),
            ':cpf' => $paciente->getCpf(),
            ':rg' => $paciente->getRg(),
            ':telefone' => $paciente->getTelefone(),
            ':email' => $paciente->getEmail(),
            ':nome_responsavel' => $paciente->getNomeResponsavel(),
            ':cns' => $paciente->getCns(),
            ':convenio' => $paciente->getConvenio(),
            ':plano_saude' => $paciente->getPlanoSaude()
        ]);
    }

    public function buscarPorId(int $id): ?Paciente {
        $sql = "SELECT * FROM pacientes WHERE id_paciente = :id_paciente";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id_paciente' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Paciente(
                $data['id_paciente'],
                $data['nome'],
                $data['data_nascimento'],
                $data['sexo'],
                $data['estado_civil'],
                $data['cpf'],
                $data['rg'],
                $data['telefone'],
                $data['email'],
                $data['nome_responsavel'],
                $data['cns'],
                $data['convenio'],
                $data['plano_saude']
            );
        }
        return null;
    }

    public function buscarTodos(): array {
        $sql = "SELECT * FROM pacientes";
        $stmt = $this->conn->query($sql);
        $pacientes = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pacientes[] = new Paciente(
                $data['id_paciente'],
                $data['nome'],
                $data['data_nascimento'],
                $data['sexo'],
                $data['estado_civil'],
                $data['cpf'],
                $data['rg'],
                $data['telefone'],
                $data['email'],
                $data['nome_responsavel'],
                $data['cns'],
                $data['convenio'],
                $data['plano_saude']
            );
        }

        return $pacientes;
    }

    public function atualizar(Paciente $paciente): bool {
        $sql = "UPDATE pacientes SET 
                    nome = :nome, 
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
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nome' => $paciente->getNome(),
            ':data_nascimento' => $paciente->getDataNascimento(),
            ':sexo' => $paciente->getSexo(),
            ':estado_civil' => $paciente->getEstadoCivil(),
            ':cpf' => $paciente->getCpf(),
            ':rg' => $paciente->getRg(),
            ':telefone' => $paciente->getTelefone(),
            ':email' => $paciente->getEmail(),
            ':nome_responsavel' => $paciente->getNomeResponsavel(),
            ':cns' => $paciente->getCns(),
            ':convenio' => $paciente->getConvenio(),
            ':plano_saude' => $paciente->getPlanoSaude(),
            ':id_paciente' => $paciente->getIdPaciente()
        ]);
    }

    public function deletar(int $id): bool {
        $sql = "DELETE FROM pacientes WHERE id_paciente = :id_paciente";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id_paciente' => $id]);
    }
}

// A partir daqui, fora da classe, vem o código que trata a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../models/Paciente.php';
    require_once '../config/Database.php';

    $paciente = new Paciente(
        null,
        $_POST['nome'] ?? '',
        $_POST['dataNascimento'] ?? '',
        $_POST['sexo'] ?? '',
        $_POST['estadoCivil'] ?? '',
        $_POST['cpf'] ?? '',
        $_POST['rg'] ?? '',
        $_POST['telefone'] ?? '',
        $_POST['email'] ?? '',
        $_POST['nomeResponsavel'] ?? '',
        $_POST['cns'] ?? '',
        $_POST['convenio'] ?? '',
        $_POST['planoSaude'] ?? ''
    );

    $controller = new PacienteController();
    $resultado = $controller->salvar($paciente);

    if ($resultado) {
        header('Location: ../views/sucesso.html');
        exit();
    } else {
        header('Location: ../views/erro.html');
        exit();
    }
}
