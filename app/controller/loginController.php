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
                    $_SESSION['usuario_id'] = $usuario['id_usuario'];
                    $_SESSION['usuario_nome'] = $usuario['nome'];
                    $_SESSION['usuario_tipo'] = $usuario['tipo'];

                    // Se for médico, buscar o id_medico
                    if ($usuario['tipo'] === 'medico') {
                        $sqlMedico = "SELECT id_medico FROM medicos WHERE id_usuario = ?";
                        $stmtMedico = $this->conn->prepare($sqlMedico);
                        $stmtMedico->execute([$usuario['id_usuario']]);
                        $medico = $stmtMedico->fetch(PDO::FETCH_ASSOC);

                        if ($medico) {
                            $_SESSION['medico_id'] = $medico['id_medico'];
                        }
                    }

                    // Se for secretário, buscar o id_secretario
                    if ($usuario['tipo'] === 'secretario') {
                        $sqlSecretario = "SELECT id_secretario FROM secretarios WHERE id_usuario = ?";
                        $stmtSecretario = $this->conn->prepare($sqlSecretario);
                        $stmtSecretario->execute([$usuario['id_usuario']]);
                        $secretario = $stmtSecretario->fetch(PDO::FETCH_ASSOC);

                        if ($secretario) {
                            $_SESSION['secretario_id'] = $secretario['id_secretario'];
                        }
                    }

                    // Se for administrador, buscar o id_administrador
                    if ($usuario['tipo'] === 'administrador') {
                        $sqlAdministrador = "SELECT id_administrador FROM administradores WHERE id_usuario = ?";
                        $stmtAdministrador = $this->conn->prepare($sqlAdministrador);
                        $stmtAdministrador->execute([$usuario['id_usuario']]);
                        $administrador = $stmtAdministrador->fetch(PDO::FETCH_ASSOC);

                        if ($administrador) {
                            $_SESSION['administrador_id'] = $administrador['id_administrador'];
                        }
                    }

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
