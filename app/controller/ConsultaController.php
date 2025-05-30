<?php

require_once '../config/Database.php';
//require_once '../model/StatusConsulta.php';
require_once '../model/Consulta.php';
require_once '../model/Paciente.php';

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

    public function listarConsultasDoDia(int $id_medico): array {
        try {
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date('Y-m-d');

            $database = new Database();
            $conn = $database->conectar();

            // Consultas pendentes (Agendada ou Cancelada)
            $stmtPendentes = $conn->prepare("
                SELECT c.*, p.nome AS nome_paciente
                FROM consultas c
                JOIN pacientes p ON c.id_paciente = p.id_paciente
                WHERE c.data = ? AND c.id_medico = ? AND (c.status = 'Agendada' OR c.status = 'Cancelada')
                ORDER BY c.hora ASC
            ");

            $stmtPendentes->execute([$dataAtual, $id_medico]);
            $resultPendentes = $stmtPendentes->fetchAll(PDO::FETCH_ASSOC);

            $consultasPendentes = array_map(function ($row) {
                return [
                    'consulta' => new Consulta(
                        $row['id_consulta'],
                        $row['motivo'],
                        $row['data'],
                        $row['hora'],
                        $row['status'],
                        $row['id_paciente'],
                        $row['id_medico'],
                        $row['id_secretario'] ?? null,
                        $row['id_administrador'] ?? null
                    ),
                    'nome_paciente' => $row['nome_paciente']
                ];
            }, $resultPendentes);

            // Consultas realizadas
            $stmtRealizadas = $conn->prepare("
                SELECT c.*, p.nome AS nome_paciente
                FROM consultas c
                JOIN pacientes p ON c.id_paciente = p.id_paciente
                WHERE c.data = ? AND c.id_medico = ? AND c.status = 'Realizada'
                ORDER BY c.hora ASC
            ");
            $stmtRealizadas->execute([$dataAtual, $id_medico]);
            $resultRealizadas = $stmtRealizadas->fetchAll(PDO::FETCH_ASSOC);

            $consultasRealizadas = array_map(function ($row) {
                return [
                    'consulta' => new Consulta(
                        $row['id_consulta'],
                        $row['motivo'],
                        $row['data'],
                        $row['hora'],
                        $row['status'],
                        $row['id_paciente'],
                        $row['id_medico'],
                        $row['id_secretario'] ?? null,
                        $row['id_administrador'] ?? null
                    ),
                    'nome_paciente' => $row['nome_paciente']
                ];
            }, $resultRealizadas);

            return [
                'pendentes' => $consultasPendentes,
                'realizadas' => $consultasRealizadas
            ];

        } catch (Exception $e) {
            echo "Erro ao listar consultas: " . $e->getMessage();
            return [];
        }
    } 
    
    public function listarTodasConsultasDoDia(): array {
    try {
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y-m-d');

        $database = new Database();
        $conn = $database->conectar();

        // Consultas pendentes (Agendada ou Cancelada)
        $stmtPendentes = $conn->prepare("
            SELECT c.*, p.nome AS nome_paciente
            FROM consultas c
            JOIN pacientes p ON c.id_paciente = p.id_paciente
            WHERE c.data = ? AND (c.status = 'Agendada' OR c.status = 'Cancelada')
            ORDER BY c.hora ASC
        ");
        $stmtPendentes->execute([$dataAtual]);
        $resultPendentes = $stmtPendentes->fetchAll(PDO::FETCH_ASSOC);

        $consultasPendentes = array_map(function ($row) {
            return [
                'consulta' => new Consulta(
                    $row['id_consulta'],
                    $row['motivo'],
                    $row['data'],
                    $row['hora'],
                    $row['status'],
                    $row['id_paciente'],
                    $row['id_medico'],
                    $row['id_secretario'] ?? null,
                    $row['id_administrador'] ?? null
                ),
                'nome_paciente' => $row['nome_paciente']
            ];
        }, $resultPendentes);

        // Consultas realizadas
        $stmtRealizadas = $conn->prepare("
            SELECT c.*, p.nome AS nome_paciente
            FROM consultas c
            JOIN pacientes p ON c.id_paciente = p.id_paciente
            WHERE c.data = ? AND c.status = 'Realizada'
            ORDER BY c.hora ASC
        ");
        $stmtRealizadas->execute([$dataAtual]);
        $resultRealizadas = $stmtRealizadas->fetchAll(PDO::FETCH_ASSOC);

        $consultasRealizadas = array_map(function ($row) {
            return [
                'consulta' => new Consulta(
                    $row['id_consulta'],
                    $row['motivo'],
                    $row['data'],
                    $row['hora'],
                    $row['status'],
                    $row['id_paciente'],
                    $row['id_medico'],
                    $row['id_secretario'] ?? null,
                    $row['id_administrador'] ?? null
                ),
                'nome_paciente' => $row['nome_paciente']
            ];
        }, $resultRealizadas);

        return [
            'pendentes' => $consultasPendentes,
            'realizadas' => $consultasRealizadas
        ];
    } catch (Exception $e) {
        echo "Erro ao listar consultas: " . $e->getMessage();
        return [];
    }
}

}
