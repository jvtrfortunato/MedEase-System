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
require_once 'ConsultaController.php';

class ProntuarioController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function salvarProntuario() {
        try {
            //Transformar o examesJson em um array
            $examesJSON = $_POST['examesJSON'];
            $examesArray = json_decode($examesJSON, true);
            
            //Salvar o objeto prontuario
            $prontuario = new Prontuario(
                idProntuario: 0,
                dataCriacao: $_SESSION['data_hoje'],
                historicoMedico: new HistoricoMedico(
                    $_POST['doencasPreExistentes'],
                    $_POST['medicacoesUsoContinuo'],
                    $_POST['cirurgiasAnteriores'],
                    $_POST['alergias'],
                    $_POST['doencasFamilia'],
                    null
                ),
                anamnese: new Anamnese(
                    $_SESSION['consulta_motivo'],
                    $_POST['queixa'],
                    $_POST['doencaAtual'],
                    $_POST['historiaSocial'],
                    $_POST['ginecoObstetrica'],
                    $_POST['revisaoSistemas'],
                    $_POST['fatoresAgravantes'],
                    $_POST['atenuantes'],
                    $_POST['tratamentosPrevios'],
                    $_POST['respostaTratamentosPrevios'],
                    null
                ),
                exameFisico: new ExameFisico(
                    $_POST['avaliacaoGeral'],
                    $_POST['sinaisVitais'],
                    $_POST['examePele'],
                    $_POST['exameCabeca'],
                    $_POST['exameCardio'],
                    $_POST['exameRespiratorio'],
                    $_POST['exameAbdominal'],
                    $_POST['exameNeuro'],
                    $_POST['exameLocomotor'],
                    null
                ),
                diagnosticoPresuntivo: $_POST['diagPresuntivo'],
                diagnosticoDiferencial: $_POST['diagDiferencial'],
                diagnosticoDefinitivo: $_POST['diagDefinitivo'],
                cid10: $_POST['cid10'],
                examesSolicitados: $examesArray,
                prescricao: new Prescricao(
                    0,
                    [], //MEDICAMENTOS
                    '',
                    null
                ),
                evolucao: $_POST['evolucao'],
                laudosExamesImagens: '', //TIRAR??
                procedimentosRealizados: '', //TIRAR??
                internacao: new Internacao(
                    $_POST['dataAdmissaoAlta'],
                    $_POST['diagInternacao'],
                    $_POST['cirurgiasInternacao'],
                    $_POST['medicosInternacao'],
                    null
                ),
                documentacao: new Documentacao(
                    0,
                    $_POST['termosConsentimento'],
                    $atestado = new Atestado(0, '', '', null),
                    $_POST['declaracoesSaude'],
                    null
                ),
                historicoProntuarios: [], //COMO IMPLEMENTAR OS PRONTUÁRIOS ANTIGOS AQUI? TALVEZ OS IDS?
                doencasNotificacaoObrigatoria: $_POST['notificacoesObrigatorias'],
                observacoesAdicionais: $_POST['obsMedicas'],
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
            $stmt = $this->conn->prepare("
                INSERT INTO historicos_medicos (
                    doencas_preexistentes,
                    medicacoes_uso_continuo,
                    cirurgias_anteriores,
                    alergias_medicamentos,
                    historico_doencas_familia,
                    id_prontuario
                ) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $prontuario->getHistoricoMedico()->getDoencasPreexistentes(),
                $prontuario->getHistoricoMedico()->getMedicacoesUsoContinuo(),
                $prontuario->getHistoricoMedico()->getCirurgiasAnteriores(),
                $prontuario->getHistoricoMedico()->getAlergiasMedicamentos(),
                $prontuario->getHistoricoMedico()->getHistoricoDoencasFamilia(),
                $prontuario->getHistoricoMedico()->getIdProntuario()
            ]);

            //Salvar a Anamnese
            $prontuario->getAnamnese()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("
                INSERT INTO anamneses (
                    motivo_consulta,
                    queixa_duracao,
                    historia_doenca_atual,
                    historia_social,
                    historia_gineco_obstetrica,
                    revisao_sistemas,
                    fatores_agravantes,
                    atenuantes,
                    tratamentos_previos,
                    resposta_tratamentos_previos, 
                    id_prontuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $prontuario->getAnamnese()->getMotivoConsulta(),
                $prontuario->getAnamnese()->getQueixaDuracao(),
                $prontuario->getAnamnese()->getHistoriaDoencaAtual(),
                $prontuario->getAnamnese()->getHistoriaSocial(),
                $prontuario->getAnamnese()->getHistoriaGinecoObstetrica(),
                $prontuario->getAnamnese()->getRevisaoSistemas(),
                $prontuario->getAnamnese()->getFatoresAgravantes(),
                $prontuario->getAnamnese()->getAtenuantes(),
                $prontuario->getAnamnese()->getTratamentosPrevios(),
                $prontuario->getAnamnese()->getRespostaTratamentosPrevios(),
                $prontuario->getAnamnese()->getIdProntuario()
            ]);

            //Salvar o Exame Físico
            $prontuario->getExameFisico()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("
                INSERT INTO exames_fisicos (
                    avaliacao_geral,
                    sinais_vitais,
                    exame_pele_anexos,
                    exame_cabeca_pescoco,
                    exame_cardiovascular,
                    exame_respiratorio,
                    exame_abdominal,
                    exame_neurologico,
                    exame_aparelho_locomotor,
                    id_prontuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $prontuario->getExameFisico()->getAvaliacaoGeral(),
                $prontuario->getExameFisico()->getSinaisVitais(),
                $prontuario->getExameFisico()->getExamePeleAnexos(),
                $prontuario->getExameFisico()->getExameCabecaPescoco(),
                $prontuario->getExameFisico()->getExameCardiovascular(),
                $prontuario->getExameFisico()->getExameRespiratorio(),
                $prontuario->getExameFisico()->getExameAbdominal(),
                $prontuario->getExameFisico()->getExameNeurologico(),
                $prontuario->getExameFisico()->getExameAparelhoLocomotor(),
                $prontuario->getExameFisico()->getIdProntuario()
            ]);

            //Pensar em como salvar a lista com o nome dos exames solicitados
            foreach ($examesArray as $exameNome) {
                $stmt = $this->conn->prepare("
                    INSERT INTO exames (nome, id_prontuario)
                    VALUES (?, ?)
                ");
                $stmt->execute([$exameNome, $idProntuario]);
            }

            //Salvar a prescrição
            $prontuario->getPrescricao()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("INSERT INTO prescricoes (id_prontuario) VALUES (?)");
            $stmt->execute([$prontuario->getPrescricao()->getIdProntuario()]);

            //Salvar internação
            $prontuario->getInternacao()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("
                INSERT INTO internacoes (
                    data_admissao_e_alta,
                    diagnostico_internacao,
                    procedimentos_cirurgicos,
                    medicos_responsaveis,
                    id_prontuario) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $prontuario->getInternacao()->getDataAdmissaoEAlta(),
                $prontuario->getInternacao()->getDiagnosticoInternacao(),
                $prontuario->getInternacao()->getProcedimentosCirurgicos(),
                $prontuario->getInternacao()->getMedicosResponsaveis(),
                $prontuario->getInternacao()->getIdProntuario()
            ]);

            //Salvar documentação
            $prontuario->getDocumentacao()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("
                INSERT INTO documentacoes (
                    termos_consentimento,
                    declaracao_saude,
                    id_prontuario) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([
                $prontuario->getDocumentacao()->getTermosConsentimento(),
                $prontuario->getDocumentacao()->getDeclaracoesSaude(),
                $prontuario->getDocumentacao()->getIdProntuario()
            ]);

            //FINALIZAR A CONSULTA
            //$controller = new ConsultaController();
            //$controller->finalizarConsulta();

        } catch (Exception $e) {
            echo "Erro ao salvar consulta: " . $e->getMessage();
        }
    }
}
