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
        $stmt = $conn->query("SELECT u.nome, u.cpf, m.id_medico FROM usuarios u INNER JOIN medicos m ON u.id_usuario = m.id_usuario");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao listar médicos: " . $e->getMessage();
        return [];
    }
    }

    public static function buscarMedico(PDO $conn, $id)
{
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
            // Pode definir um endereço vazio, ou lançar exceção, se quiser
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
                $endereco    // <-- PASSA O OBJETO ENDEREÇO AQUI
            );
        }

        return null;

    } catch (PDOException $e) {
        echo "Erro ao buscar médico: " . $e->getMessage();
        return null;
    }
}


    // Representar como array
    public function toArray(): array {
        return [
            'nome' => $this->getNome(),
            'cpf' => $this->getCpf(),
            'telefone' => $this->getTelefone(),
            'dataNascimento' => $this->getDataNascimento(),
            'sexo' => $this->getSexo(),
            'email' => $this->getEmail(),
            'senha' => $this->getSenha(),
            'tipo' => $this->getTipo(),
            'crm' => $this->crm,
            'especialidade' => $this->especialidade
            // 'endereco' => $this->getEndereco()->toArray() // Removido por não existir
        ];
    }
}


// $conn->beginTransaction();
// Essa função inicia uma transação. A partir daí, todas as operações feitas (inserir, atualizar, deletar) ficam "pendentes", ou seja, não são salvas de forma permanente no banco até que você diga que está tudo certo.

// $conn->commit();
// Essa função confirma (grava de verdade) todas as operações feitas desde o beginTransaction(). A partir disso, os dados são efetivamente salvos no banco.

// $conn->rollBack();
// Se aconteceu algum erro durante a transação (por exemplo, um insert falhou), você pode usar essa função para cancelar todas as operações feitas até o momento.

// Assim, nenhuma alteração será salva no banco.
