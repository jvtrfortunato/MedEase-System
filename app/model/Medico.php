<?php

require_once '../config/Database.php';
require_once '../controller/MedicoController.php';
require_once 'Usuario.php';
require_once 'Endereco.php';

class Medico extends Usuario
{
    private string $crm;
    private string $especialidade;

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
        string $especialidade
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
    }

    // Getters
    public function getCrm(): string { return $this->crm; }
    public function getEspecialidade(): string { return $this->especialidade; }

    // Setters
    public function setCrm(string $crm): void { $this->crm = $crm; }
    public function setEspecialidade(string $especialidade): void { $this->especialidade = $especialidade; }

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

    // Representar como array
    public function toArray(): array {
        return [
            'idUsuario' => $this->getIdUsuario(),
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
