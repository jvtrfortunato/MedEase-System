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

    public function salvarProntuario() {
        try { 
            //Salvar o objeto prontuario
            $prontuario = new Prontuario(
                idProntuario: 0,
                dataCriacao: $_SESSION['data_hoje'],
                historicoMedico: new HistoricoMedico(
                    '',
                    '',
                    '',
                    '',
                    '',
                    null
                ),
                anamnese: new Anamnese(
                    $_SESSION['consulta_motivo'],
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
                exameFisico: $exameFisico = new ExameFisico(
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
                diagnosticoPresuntivo: '',
                diagnosticoDiferencial: '',
                diagnosticoDefinitivo: '',
                cid10: '',
                examesSolicitados: [],
                prescricao: new Prescricao(
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
                evolucao: '',
                laudosExamesImagens: '',
                procedimentosRealizados: '',
                internacao: new Internacao(
                    '',
                    '',
                    '',
                    '',
                    null
                ),
                documentacao: new Documentacao(
                    null,
                    '',
                    $atestado = new Atestado(null, '', '', null),
                    '',
                    null
                ),
                historicoProntuarios: [],
                doencasNotificacaoObrigatoria: '',
                observacoesAdicionais: '',
                idPaciente: $_SESSION['paciente_id'],
                idMedico: $_SESSION['medico_id']
            );
            
            $stmt = $this->conn->prepare("
                INSERT INTO prontuarios ( 
                    data_criacao, 
                    diagnostico_presuntivo, 
                    diagnostico_diferencial,
                    diagnostico_definitivo,
                    cid10,
                    evolucao,
                    laudos_exames_imagens,
                    procedimentos_realizados,
                    doencas_notificacao_obrigatoria,
                    observacoes_adicionais,
                    id_paciente,
                    id_medico
                    )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $prontuario->getDataCriacao(),
                $prontuario->getDiagnosticoPresuntivo(),
                $prontuario->getDiagnosticoDiferencial(),
                $prontuario->getDiagnosticoDefinitivo(),
                $prontuario->getCid10(),
                $prontuario->getEvolucao(),
                $prontuario->getLaudosExamesImagens(),
                $prontuario->getProcedimentosRealizados(),
                $prontuario->getDoencasNotificacaoObrigatoria(),
                $prontuario->getObservacoesAdicionais(),
                $prontuario->getIdPaciente(),
                $prontuario->getIdMedico()
            ]);

            //Recupera o id do prontuário
            $idProntuario = $this->conn->lastInsertId();

            //Salvar o Histórico Médico
            $prontuario->getHistoricoMedico()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("INSERT INTO historicos_medicos (id_prontuario) VALUES (?)");
            $stmt->execute([$prontuario->getHistoricoMedico()->getIdProntuario()]);

            //Salvar a Anamnese
            $prontuario->getAnamnese()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("INSERT INTO anamneses (motivo_consulta, id_prontuario) VALUES (?, ?)");
            $stmt->execute([
                $prontuario->getAnamnese()->getMotivoConsulta(),
                $prontuario->getAnamnese()->getIdProntuario()
            ]);

            //Salvar o Exame Físico
            $prontuario->getExameFisico()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("INSERT INTO exames_fisicos (id_prontuario) VALUES (?)");
            $stmt->execute([$prontuario->getExameFisico()->getIdProntuario()]);

            //Pensar em como salvar a lista com o nome dos exames solicitados
            //Lógica aqui

            //Salvar a prescrição
            $prontuario->getPrescricao()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("INSERT INTO prescricoes (id_prontuario) VALUES (?)");
            $stmt->execute([$prontuario->getPrescricao()->getIdProntuario()]);

            //Salvar internação
            $prontuario->getInternacao()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("INSERT INTO internacoes (id_prontuario) VALUES (?)");
            $stmt->execute([$prontuario->getInternacao()->getIdProntuario()]);

            //Salvar documentação
            $prontuario->getDocumentacao()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("INSERT INTO documentacoes (id_prontuario) VALUES (?)");
            $stmt->execute([$prontuario->getDocumentacao()->getIdProntuario()]);

            //header("Location: ../views/atendimentos-dia.php");
                //exit;
        } catch (Exception $e) {
            echo "Erro ao salvar consulta: " . $e->getMessage();
        }
    }
}
