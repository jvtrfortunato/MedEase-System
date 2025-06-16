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
                idAdministrador: $id_administrador,
                idSecretario: $id_secretario,
                idMedico: (int) $_POST['id_medico'],
                idPaciente: (int) $_POST['id_paciente'],
            );

            // Monta SQL conforme o agendador
            if ($id_secretario !== null) {
                $stmt = $this->conn->prepare("
                    INSERT INTO consultas (motivo, data, hora, status, id_secretario, id_medico, id_paciente)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $consulta->getMotivo(),
                    $consulta->getData(),
                    $consulta->getHora(),
                    $consulta->getStatus(),
                    $consulta->getIdSecretario(),
                    $consulta->getIdMedico(),
                    $consulta->getIdPaciente()
                ]);
            } else {
                $stmt = $this->conn->prepare("
                    INSERT INTO consultas (motivo, data, hora, status, id_administrador, id_medico, id_paciente)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $consulta->getMotivo(),
                    $consulta->getData(),
                    $consulta->getHora(),
                    $consulta->getStatus(),
                    $consulta->getIdAdministrador(),
                    $consulta->getIdMedico(),
                    $consulta->getIdPaciente()
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
                WHERE DATE(c.start) = ? AND c.id_medico = ? AND (c.status = 'Agendada' OR c.status = 'Cancelada')
                ORDER BY c.start ASC
            ");

            $stmtPendentes->execute([$dataAtual, $id_medico]);
            $resultPendentes = $stmtPendentes->fetchAll(PDO::FETCH_ASSOC);

            $consultasPendentes = array_map(function ($row) {
                return [
                    'consulta' => new Consulta(
                        $row['id'],
                        $row['title'],
                        $row['color'],
                        $row['start'],
                        $row['end'],
                        $row['status'],
                        $row['id_administrador'] ?? null,
                        $row['id_secretario'] ?? null,
                        $row['id_medico'],
                        $row['id_paciente']
                    ),
                    'nome_paciente' => $row['nome_paciente']
                ];
            }, $resultPendentes);

            // Consultas realizadas
            $stmtRealizadas = $conn->prepare("
                SELECT c.*, p.nome AS nome_paciente
                FROM consultas c
                JOIN pacientes p ON c.id_paciente = p.id_paciente
                WHERE DATE(c.start) = ? AND c.id_medico = ? AND c.status = 'Realizada'
                ORDER BY c.start ASC
            ");
            $stmtRealizadas->execute([$dataAtual, $id_medico]);
            $resultRealizadas = $stmtRealizadas->fetchAll(PDO::FETCH_ASSOC);

            $consultasRealizadas = array_map(function ($row) {
                return [
                    'consulta' => new Consulta(
                        $row['id'],
                        $row['title'],
                        $row['color'],
                        $row['start'],
                        $row['end'],
                        $row['status'],
                        $row['id_administrador'] ?? null,
                        $row['id_secretario'] ?? null,
                        $row['id_medico'],
                        $row['id_paciente']
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
                WHERE DATE(c.start) = ? AND (c.status = 'Agendada' OR c.status = 'Cancelada')
                ORDER BY c.start ASC
            ");
            $stmtPendentes->execute([$dataAtual]);
            $resultPendentes = $stmtPendentes->fetchAll(PDO::FETCH_ASSOC);

            $consultasPendentes = array_map(function ($row) {
                return [
                    'consulta' => new Consulta(
                        $row['id'],
                        $row['title'],
                        $row['color'],
                        $row['start'],
                        $row['end'],
                        $row['status'],
                        $row['id_administrador'] ?? null,
                        $row['id_secretario'] ?? null,
                        $row['id_medico'],
                        $row['id_paciente']
                    ),
                    'nome_paciente' => $row['nome_paciente']
                ];
            }, $resultPendentes);

            // Consultas realizadas
            $stmtRealizadas = $conn->prepare("
                SELECT c.*, p.nome AS nome_paciente
                FROM consultas c
                JOIN pacientes p ON c.id_paciente = p.id_paciente
                WHERE DATE(c.start) = ? AND c.status = 'Realizada'
                ORDER BY c.start ASC
            ");
            $stmtRealizadas->execute([$dataAtual]);
            $resultRealizadas = $stmtRealizadas->fetchAll(PDO::FETCH_ASSOC);

            $consultasRealizadas = array_map(function ($row) {
                return [
                    'consulta' => new Consulta(
                        $row['id'],
                        $row['title'],
                        $row['color'],
                        $row['start'],
                        $row['end'],
                        $row['status'],
                        $row['id_administrador'] ?? null,
                        $row['id_secretario'] ?? null,
                        $row['id_medico'],
                        $row['id_paciente']
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

    public function buscarConsulta(int $id_consulta): ?Consulta {
        //Busca a consulta
        $sqlConsulta = "SELECT * FROM consultas WHERE id = :id_consulta";
        $stmtConsulta = $this->conn->prepare($sqlConsulta);
        $this->conn->beginTransaction();
        $stmtConsulta->execute([':id_consulta' => $id_consulta]);
        $dataConsulta = $stmtConsulta->fetch(PDO::FETCH_ASSOC);

        if (!$dataConsulta) {
            return null;
        }

        return new Consulta(
            $dataConsulta['id'],
            $dataConsulta['title'],
            $dataConsulta['color'],
            $dataConsulta['start'],
            $dataConsulta['end'],
            $dataConsulta['status'],
            $dataConsulta['id_administrador'],
            $dataConsulta['id_secretario'],
            $dataConsulta['id_paciente'],
            $dataConsulta['id_medico']
        );
    }

    public function iniciarConsulta() {
        $idConsulta = $_GET['consulta_id'];
        $_SESSION['consulta_id'] = $idConsulta;

        try {
            $stmtConsulta = $this->conn->prepare("SELECT * FROM consultas WHERE id = ?");
            $stmtConsulta->execute([$idConsulta]);
            $dadosConsulta = $stmtConsulta->fetch(PDO::FETCH_ASSOC);

            if (!$dadosConsulta) {
                throw new Exception('Consulta não encontrada.');
            }

            $idPaciente = $dadosConsulta['id_paciente'];
            $idMedico = $dadosConsulta['id_medico'];
            
            $_SESSION['paciente_id'] = $idPaciente;

            // Redireciona para a tela do prontuário
            header("Location: ../views/prontuario.php");
            exit;      

        } catch(Exception $e) {
            echo "Erro ao iniciar consulta: " . $e->getMessage();
        }
    }

    public function finalizarConsulta() {
        try {
            // Atualiza o status da consulta para "Realizada"
            $stmtUpdate = $this->conn->prepare("UPDATE consultas SET status = 'Realizada' WHERE id = ?");
            $stmtUpdate->execute([$_SESSION['consulta_id']]);

            // Redireciona para a tela do prontuário
            header("Location: ../views/atendimentos-dia.php");
            exit;

        } catch (Exception $e) {
            echo "Erro ao finalizar consulta: " . $e->getMessage();
        }
    }

    public function listarTodasConsultas(): array {
        try {
            // Todas as consultas
            $stmtConsultas = $this->conn->prepare("
                SELECT c.*, 
                    p.nome AS nome_paciente,
                    u.nome AS nome_medico
                FROM consultas c
                JOIN pacientes p ON c.id_paciente = p.id_paciente
                JOIN medicos m ON c.id_medico = m.id_medico
                JOIN usuarios u ON u.id_usuario = m.id_usuario
            ");
            $stmtConsultas->execute();
            $resultConsultas = $stmtConsultas->fetchAll(PDO::FETCH_ASSOC);

            $consultas = array_map(function ($row) {
                return [
                    'consulta' => new Consulta(
                        $row['id'],
                        $row['title'],
                        $row['color'],
                        $row['start'],
                        $row['end'],
                        $row['status'],
                        $row['id_administrador'] ?? null,
                        $row['id_secretario'] ?? null,
                        $row['id_medico'],
                        $row['id_paciente']
                    ),
                    'nome_paciente' => $row['nome_paciente'],
                    'nome_medico' => $row['nome_medico']
                ];
            }, $resultConsultas);

            return $consultas;

        } catch (Exception $e) {
            echo "Erro ao listar consultas: " . $e->getMessage();
            return [];

        }
    }

    
//     public function buscarTodasConsultas() {
//         $consultaModel = new Consulta();
//         return $consultaModel->buscarTodas();
//     }

//     public function buscarConsultasPorMedico($idMedico) {
//     $consultaModel = new Consulta();
//     return $consultaModel->buscarPorMedico($idMedico);
//    }




}
