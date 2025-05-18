<?php

require_once 'Usuario.php';
require_once 'Endereco.php';

class Secretario extends Usuario {
    public function __construct(
        int $idUsuario,
        string $nome, 
        string $cpf,
        string $telefone, 
        string $dataNascimento,
        string $sexo,
        string $email, 
        string $senha, 
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
            'secretario'
        );
    }


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

        // Inserir Secretario
        $sqlSecretario = "INSERT INTO secretarios (id_usuario)
                      VALUES (?)";
        $stmt = $conn->prepare($sqlSecretario);
        $stmt->execute([

            $idUsuario
        ]);

        $idSecretario = $idUsuario;

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
            $idSecretario
        ]);

        $conn->commit();
        return true;
        
    } catch (PDOException $e) {
        $conn->rollBack();
        throw $e;
    }
    }

    public function listarSecretarios(PDO $conn) {
    try {
        $stmt = $conn->query("SELECT u.nome, u.cpf FROM usuarios u INNER JOIN secretarios s ON u.id_usuario = s.id_usuario");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao listar secretários: " . $e->getMessage();
        return [];
    }
    }

}

