<?php

require_once '../config/Database.php';
session_start();

class LoginController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cpf = $_POST['cpf'];
            $senha = $_POST['senha'];

            if (empty($cpf) || empty($senha)) {
                echo "CPF e senha são obrigatórios.";
                return;
            }

            $sql = "SELECT * FROM usuarios WHERE cpf = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$cpf]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                
                if ($usuario['senha'] === $senha) {
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nome'] = $usuario['nome'];
                    $_SESSION['usuario_tipo'] = $usuario['tipo'];

                    // Redirecionar conforme o tipo
                    switch ($usuario['tipo']) {
                        case 'administrador':
                            header("Location: ../views/home-administrador.php");
                            break;
                        case 'medico':
                            header("Location: ../views/home-medico.php");
                            break;
                        case 'secretario':
                            header("Location: ../views/home-secretario.php");
                            break;
                        default:
                            echo "Tipo de usuário inválido.";
                            break;
                    }
                    exit;
                } else {
                    echo "Senha incorreta.";
                }
            } else {
                echo "Usuário não encontrado.";
            }
        }
    }
}

$controller = new LoginController();
$controller->autenticar();
?>
