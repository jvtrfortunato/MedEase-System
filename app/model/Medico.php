<?php

require_once '../config/Database.php';
require_once '../controller/MedicoController.php';
require_once 'Usuario.php';
require_once 'Endereco.php';

class Medico extends Usuario
{
    private string $crm;
    private string $especialidade;
    private Endereco $endereco;

    public function __construct(
        int $idUsuario,
        string $nome,
        string $cpf,
        string $telefone,
        string $dataNascimento,
        string $sexo,
        string $email,
        string $senha,
        string $crm,
        string $especialidade,
        Endereco $endereco
    ) {
        parent::__construct(
            $idUsuario,
            $nome,
            $cpf,
            $telefone,
            $dataNascimento,
            $sexo,
            $email,
            $senha,
            'medico' // tipo fixado
        );

        $this->crm = $crm;
        $this->especialidade = $especialidade;
        $this->endereco = $endereco;
    }

    // Getters
    public function getCrm(): string { return $this->crm; }
    public function getEspecialidade(): string { return $this->especialidade; }
    public function getEndereco(): Endereco {return $this->endereco;}

    // Setters
    public function setCrm(string $crm): void { $this->crm = $crm; }
    public function setEspecialidade(string $especialidade): void { $this->especialidade = $especialidade; }
    public function setEndereco(Endereco $endereco): void {$this->endereco = $endereco;}


    // Salvar no banco (com transação completa)
    public function salvar(PDO $conn, Endereco $endereco): bool {        
        try {
            $conn->beginTransaction();

            // Inserir usuário
            $sqlUsuario = "INSERT INTO usuarios (nome, cpf, telefone, data_nascimento, sexo, email, senha, tipo)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlUsuario);
            $stmt->execute([
                $this->getNome(),
                $this->getCpf(),
                $this->getTelefone(),
                $this->getDataNascimento(),
                $this->getSexo(),
                $this->getEmail(),
                $this->getSenha(),
                $this->getTipo()
            ]);

            $idUsuario = $conn->lastInsertId();

            // Inserir médico
            $sqlMedico = "INSERT INTO medicos (crm, especialidade, id_usuario)
                        VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sqlMedico);
            $stmt->execute([
                $this->getCrm(),
                $this->getEspecialidade(),
                $idUsuario
            ]);

            // Inserir endereço
            $sqlEndereco = "INSERT INTO enderecos (rua, numero, bairro, cidade, estado, cep, id_usuario)
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlEndereco);
            $stmt->execute([
                $endereco->getRua(),
                $endereco->getNumero(),
                $endereco->getBairro(),
                $endereco->getCidade(),
                $endereco->getEstado(),
                $endereco->getCep(),
                $idUsuario
            ]);

            $conn->commit();
            return true;
            
        } catch (PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public function listarMedicos(PDO $conn) {
        try {
            $stmt = $conn->query("SELECT u.nome, u.cpf, m.id_medico, m.crm, m.especialidade FROM usuarios u INNER JOIN medicos m ON u.id_usuario = m.id_usuario ORDER BY u.nome ASC");

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar médicos: " . $e->getMessage();
            return [];
        }
    }

    public static function buscarMedico(PDO $conn, $id) {
        try {

            //  buscar dados do médico
            $sql = "SELECT u.*, m.id_medico, m.crm, m.especialidade 
                    FROM usuarios u 
                    INNER JOIN medicos m ON u.id_usuario = m.id_usuario 
                    WHERE m.id_medico = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            $idUsuario = $dados['id_usuario'];       


            // depois buscar endereço
            $sqlEndereco = "SELECT * FROM enderecos WHERE id_usuario = :idUsuario";
            $stmtEndereco = $conn->prepare($sqlEndereco);
            $stmtEndereco->execute([':idUsuario' => $idUsuario]);
            $dataEndereco = $stmtEndereco->fetch(PDO::FETCH_ASSOC);

            $endereco = null;
            if ($dataEndereco) {
                $endereco = new Endereco(
                    $dataEndereco['rua'],
                    $dataEndereco['numero'],
                    $dataEndereco['bairro'],
                    $dataEndereco['cidade'],
                    $dataEndereco['estado'],
                    $dataEndereco['cep']
                );
            } else {
                // Pode definir um endereço vazio
                $endereco = new Endereco('', '', '', '', '', '');
            }

            if ($dados) {
                return new Medico(
                    (int)($dados['id_usuario'] ?? 0),
                    $dados['nome'],
                    $dados['cpf'],
                    $dados['telefone'],
                    $dados['data_nascimento'],
                    $dados['sexo'],
                    $dados['email'],
                    $dados['senha'],
                    $dados['crm'],
                    $dados['especialidade'],
                    $endereco    // <-- PASSA O OBJETO ENDEREÇO
                );
            }

            return null;

        } catch (PDOException $e) {
            echo "Erro ao buscar médico: " . $e->getMessage();
            return null;
        }
    }

    public static function buscarPorNome(PDO $conn, $nome) {
        $sql = "
            SELECT u.*, m.id_medico, m.crm, m.especialidade
            FROM usuarios u
            INNER JOIN medicos m ON u.id_usuario = m.id_usuario
            WHERE u.nome LIKE ?
            ORDER BY u.nome ASC
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute(["%$nome%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
