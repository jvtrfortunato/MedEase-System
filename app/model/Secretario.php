<?php
require_once '../config/Database.php';
require_once '../controller/SecretarioController.php';
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
            'secretario'
        );

        $this->endereco = $endereco;
    }

    public function getEndereco(): Endereco {return $this->endereco;}
    public function setEndereco(Endereco $endereco): void {$this->endereco = $endereco;}


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
        $stmt = $conn->query("
            SELECT u.id_usuario, u.nome, u.cpf, s.id_secretario 
            FROM usuarios u 
            INNER JOIN secretarios s ON u.id_usuario = s.id_usuario
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao listar secretários: " . $e->getMessage();
        return [];
    }
}


    public static function buscarSecretario(PDO $conn, $id){

        try{ 
    
                $sqlSecretario = "SELECT u.* FROM usuarios u 
                    INNER JOIN secretarios s ON u.id_usuario = s.id_usuario 
                    WHERE s.id_secretario = :id";

                $stmt = $conn->prepare($sqlSecretario);
                $stmt->execute([':id' => $id]);

                $dados = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verifica se encontrou algum dado
                if (!$dados) {
                    echo "Secretário não encontrado.";
                    return null;
                }

            // Agora sim, é seguro continuar o processamento com $dados['id_usuario'], etc.

            if (!$dados) {
                echo "Secretário não encontrado.";
                return null;
            }

            $idUsuario = $dados['id_usuario'];   
        
            
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
            return new Secretario(
                (int)($dados['id_usuario'] ?? 0),
                $dados['nome'],
                $dados['cpf'],
                $dados['telefone'],
                $dados['data_nascimento'],
                $dados['sexo'],
                $dados['email'],
                $dados['senha'],
                $endereco    // <-- PASSA O OBJETO ENDEREÇO AQUI
            );

        }
        return null;

        } catch (PDOException $e) {
            echo "Erro ao buscar secretário: " . $e->getMessage();
            return null;
        }
       
    }

    // Exemplo na função buscarPorNome (ou método similar)
    public static function buscarPorNome(PDO $conn, $nome) {
        $sql = "SELECT u.*, e.rua, e.numero, e.bairro, e.cidade, e.estado, e.cep 
                FROM usuarios u
                INNER JOIN enderecos e ON u.id_usuario = e.id_usuario
                WHERE u.nome LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%$nome%"]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados) {
            $endereco = new Endereco(
                $dados['rua'],
                $dados['numero'],
                $dados['bairro'],
                $dados['cidade'],
                $dados['estado'],
                $dados['cep']
            );

            return new Secretario(
                $dados['id_usuario'],
                $dados['nome'],
                $dados['cpf'],
                $dados['telefone'],
                $dados['data_nascimento'],
                $dados['sexo'],
                $dados['email'],
                $dados['senha'],
                $endereco
            );
        }
        return null;
    }



}

