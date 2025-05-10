<?php

session_start(); // Inicia a sessão
require_once '../config/Database.php';
//require_once '../model/StatusConsulta.php';
require_once '../model/Consulta.php';

if (!isset($_SESSION['usuario_id'])) {
    // Se o usuário não estiver logado, redireciona
    header("Location: ../views/login.php");
    exit;
}

class ConsultaController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function salvarConsulta() {
        try {
            $id_usuario = $_SESSION['usuario_id'];
            $tipo_usuario = $_SESSION['usuario_tipo']; // 'secretario' ou 'administrador'

            $id_secretario = null;
            $id_administrador = null;

            // Recupera o ID do profissional (secretário ou administrador)
            if ($tipo_usuario === 'secretario') {
                $stmt = $this->conn->prepare("SELECT id_secretario FROM secretarios WHERE id_usuario = ?");
                $stmt->execute([$id_usuario]);
                $id_secretario = $stmt->fetchColumn();
                if (!$id_secretario) throw new Exception("Secretário não encontrado.");
            } elseif ($tipo_usuario === 'administrador') {
                $stmt = $this->conn->prepare("SELECT id_administrador FROM administradores WHERE id_usuario = ?");
                $stmt->execute([$id_usuario]);
                $id_administrador = $stmt->fetchColumn();
                if (!$id_administrador) throw new Exception("Administrador não encontrado.");
            } else {
                throw new Exception("Tipo de usuário não autorizado para agendamento.");
            }

            // Cria objeto StatusConsulta
            //$status = new StatusConsulta(StatusConsulta::Agendada); USAR ENUM OU NÃO?

            // Cria objeto Consulta com os dados do formulário
            $consulta = new Consulta(
                idConsulta: 0,
                motivo: $_POST['motivo'],
                data: $_POST['data'],
                hora: $_POST['hora'],
                //status: $status,
                status: 'Agendada',
                idPaciente: (int) $_POST['id_paciente'],
                idMedico: (int) $_POST['id_medico'],
                idSecretario: $id_secretario,
                idAdministrador: $id_administrador
            );

            // Monta SQL conforme o agendador
            if ($id_secretario !== null) {
                $stmt = $this->conn->prepare("
                    INSERT INTO consultas (motivo, data, hora, status, id_secretario, id_paciente, id_medico)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $consulta->getMotivo(),
                    $consulta->getData(),
                    $consulta->getHora(),
                    $consulta->getStatus(),
                    $consulta->getIdSecretario(),
                    $consulta->getIdPaciente(),
                    $consulta->getIdMedico()
                ]);
            } else {
                $stmt = $this->conn->prepare("
                    INSERT INTO consultas (motivo, data, hora, status, id_administrador, id_paciente, id_medico)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $consulta->getMotivo(),
                    $consulta->getData(),
                    $consulta->getHora(),
                    $consulta->getStatus(),
                    $consulta->getIdAdministrador(),
                    $consulta->getIdPaciente(),
                    $consulta->getIdMedico()
                ]);
            }

            header("Location: ../views/calendario.php?modo=agendar&data");
            exit;

        } catch (Exception $e) {
            echo "Erro ao salvar consulta: " . $e->getMessage();
        }
    }
}
