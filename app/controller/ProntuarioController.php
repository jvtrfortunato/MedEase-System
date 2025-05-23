<?php
require_once '../config/Database.php';
require_once '../model/Consulta.php';
require_once '../model/Endereco.php';
require_once '../model/Paciente.php';
require_once '../model/Prontuario.php';
require_once '../model/HistoricoMedico.php';
require_once '../model/Anamnese.php';
require_once '../model/ExameFisico.php';
require_once '../model/Prescricao.php';
require_once '../model/Internacao.php';
require_once '../model/Documentacao.php';
require_once '../model/Atestado.php';

class ProntuarioController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function iniciarProntuario() {
        $consultaId = $_GET['consulta_id'];

        try {
            $db = new Database();
            $pdo = $db->conectar();

            // Buscar consulta
            $stmtConsulta = $pdo->prepare("SELECT * FROM consultas WHERE id_consulta = ?");
            $stmtConsulta->execute([$consultaId]);
            $dadosConsulta = $stmtConsulta->fetch(PDO::FETCH_ASSOC);

            if (!$dadosConsulta) {
                throw new Exception('Consulta não encontrada.');
            }

            $idPaciente = $dadosConsulta['id_paciente'];
            $idMedico = $dadosConsulta['id_medico'];

            // Buscar endereço
            $stmtEndereco = $pdo->prepare("SELECT * FROM enderecos WHERE id_paciente = ?");
            $stmtEndereco->execute([$idPaciente]);
            $dadosEndereco = $stmtEndereco->fetch(PDO::FETCH_ASSOC);

            if (!$dadosEndereco) {
                throw new Exception('Endereço não encontrado.');
            }

            // Criar objeto Endereço
            $endereco = new Endereco(
                $dadosEndereco['rua'],
                $dadosEndereco['numero'],
                $dadosEndereco['bairro'],
                $dadosEndereco['cidade'],
                $dadosEndereco['estado'],
                $dadosEndereco['cep']
            );

            // Buscar paciente
            $stmtPaciente = $pdo->prepare("SELECT * FROM pacientes WHERE id_paciente = ?");
            $stmtPaciente->execute([$idPaciente]);
            $dadosPaciente = $stmtPaciente->fetch(PDO::FETCH_ASSOC);

            if (!$dadosPaciente) {
                throw new Exception('Paciente não encontrado.');
            }

            // Criar objeto Paciente
            $paciente = new Paciente(
                $dadosPaciente['id_paciente'],
                $dadosPaciente['nome'],
                $dadosPaciente['data_nascimento'],
                $dadosPaciente['sexo'],
                $dadosPaciente['estado_civil'],
                $dadosPaciente['cpf'],
                $dadosPaciente['rg'],
                $dadosPaciente['telefone'],
                $dadosPaciente['email'],
                $dadosPaciente['nome_responsavel'],
                $dadosPaciente['cns'],
                $dadosPaciente['convenio'],
                $dadosPaciente['plano_saude'],
                $endereco
            );

            // Criar objeto Prontuario com atributos vazios
            $prontuario = new Prontuario(
                0, // ID
                date('Y-m-d H:i:s'), // dataCriacao atual
                $historicoMedico = new HistoricoMedico(
                    '',
                    '',
                    '',
                    '',
                    '',
                    null
                ),
                $anamnese = new Anamnese(
                    $dadosConsulta['motivo'],
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    null
                ),
                $exameFisico = new ExameFisico(
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    null
                ),
                '', '', '', '', // diagnostico, conduta, observacoes, cid
                [], // examesSolicitados
                $prescricao = new Prescricao(
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    0,
                    '',
                    '',
                    null
                ),
                '', '', '', // parecer, justificativa, tipo
                $internacao = new Internacao(
                    '',
                    '',
                    '',
                    '',
                    null
                ),
                $documentacao = new Documentacao(
                    null,
                    '',
                    $atestado = new Atestado(null, '', '', null),
                    '',
                    null
                ),
                [], // historico
                '', '', // dataAlta, observacoesAlta
                $paciente,
                $idMedico
            );

            // Armazena prontuário na sessão
            $_SESSION['prontuario'] = serialize($prontuario);

            // Redireciona para a tela do prontuário
            header("Location: ../views/prontuario.php");
            exit;

        } catch (Exception $e) {
            echo "Erro ao iniciar consulta: " . $e->getMessage();
        }
    }

    public function salvarProntuario() {
        $examesSolicitadosJson = $_POST['examesSolicitados'] ?? '[]';
        $examesSolicitadosArray = json_decode($examesSolicitadosJson, true);
    }
}

$controller = new ProntuarioController();

if (isset($_GET['acao']) === 'iniciar' && isset($_GET['consulta_id'])) {
    $controller->iniciarProntuario();
}

$acao = $_POST['acao'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($acao) {
        case 'salvar':
            $controller->salvarProntuario();
            break;
        case 'editar':
            $controller->editarProntuario();
            break;
        case 'deletar':
            $controller->deletarProntuario();
            break;
        default:
            echo "Ação inválida.";
    }
}
