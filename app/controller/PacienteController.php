<?php

require_once '../model/Paciente.php';
require_once '../model/Endereco.php';
require_once '../config/Database.php';

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
