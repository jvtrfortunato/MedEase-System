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
require_once '../model/Medicamento.php';
require_once '../model/Exame.php';
require_once '../model/AtestadoAcompanhante.php';
require_once '../model/AtestadoComparecimento.php';
require_once '../model/AtestadoAfastamento.php';
require_once 'ConsultaController.php';

class ProntuarioController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function salvarProntuario() {
        try {
            //converter json para objetos medicamento
            $listaMedicamentos = [];
            if (isset($_POST['medicamentosJSON'])) {
                $medicamentosArray = json_decode($_POST['medicamentosJSON'], true);

                foreach ($medicamentosArray as $med) {
                    $medicamento = new Medicamento(
                        idMedicamento: 0,
                        nomeMedicamento: $med['principioAtivo'],
                        concentracao: $med['concentracao'],
                        formaFarmaceutica: $med['forma'],
                        viaAdministracao: $med['via'],
                        tipoReceita: $med['tipoReceita'],
                        intervaloDose: $med['intervalo'],
                        frequenciaDose: $med['frequencia'],
                        turnoDose: $med['turno'],
                        dataInicio: $med['inicioTratamento'],
                        quantidadeDuracao: $med['duracao'],
                        tipoDuracao: $med['duracaoTipo'],
                        idPrescricao: null
                    );
                    $listaMedicamentos[] = $medicamento;
                }
            }

            //Transformar o examesJson em objetos
            $listaExames = [];
            if(isset($_POST['examesJSON'])) {
                $examesArray = json_decode($_POST['examesJSON'], true);

                foreach ($examesArray as $nomeExame) {
                    $exame = new Exame(
                        idExame: 0,
                        nomeExame: $nomeExame,
                        idProntuario: 0
                    );
                    $listaExames[] = $exame;
                }
            }
             
            //Converter as recomendações da prescrição
            $recomendacoes = isset($_POST['recomendacoesJSON']) ? $_POST['recomendacoesJSON'] : null;

            //Converter o atestado
            $atestadoObj = null;

            if (isset($_POST['atestadoJSON'])) {
                $atestadoData = json_decode($_POST['atestadoJSON'], true);

                if (isset($atestadoData['tipo'])) {
                    switch ($atestadoData['tipo']) {
                        case 'afastamento':
                            $atestadoObj = new AtestadoAfastamento(
                                idAtestado: 0,
                                cid10: $atestadoData['cid10'],
                                textoPrincipal: $atestadoData['texto'],
                                idDocumentacao: null,
                                diasAfastamento: $atestadoData['numeroDias'],
                                dataInicio: $atestadoData['dataInicio'],
                                dataRetorno: $atestadoData['dataRetorno']                                                              
                            );
                            break;

                        case 'comparecimento':
                            $atestadoObj = new AtestadoComparecimento(
                                idAtestado: 0,
                                cid10: $atestadoData['cid10'],
                                textoPrincipal: $atestadoData['texto'],
                                idDocumentacao: null,
                                data: $atestadoData['data'],
                                horarioChegada: $atestadoData['horarioChegada'],
                                horarioSaida: $atestadoData['horarioSaida']
                            );
                            break;

                        case 'acompanhante':
                            $atestadoObj = new AtestadoAcompanhante(
                                idAtestado: 0,
                                cid10: $atestadoData['cid10'],
                                textoPrincipal: $atestadoData['texto'],
                                idDocumentacao: null,
                                nomeAcompanhante: $atestadoData['nomeAcompanhante'],
                                cpfAcompanhante: $atestadoData['cpfAcompanhante'],
                                parentescoAcompanhante: $atestadoData['parentesco'],
                                data: $atestadoData['data'], 
                                horarioChegada: $atestadoData['horarioChegada'],
                                horarioSaida: $atestadoData['horarioSaida']
                            );
                            break;

                        default:
                            throw new Exception("Tipo de atestado desconhecido: " . $atestadoData['tipo']);
                    }
                }
            }

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
                examesSolicitados: $listaExames,
                prescricao: new Prescricao(
                    0,
                    $listaMedicamentos, //MEDICAMENTOS
                    $recomendacoes, //RECOMENDAÇÕES
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
                    $atestadoObj,
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

            //salvar a lista com o nome dos exames solicitados
            foreach ($examesArray as $exameNome) {
                $stmt = $this->conn->prepare("
                    INSERT INTO exames (nome, id_prontuario)
                    VALUES (?, ?)
                ");
                $stmt->execute([$exameNome, $idProntuario]);
            }

            //Salvar a prescricao
            $prontuario->getPrescricao()->setIdProntuario($idProntuario);
            $stmt = $this->conn->prepare("
                INSERT INTO prescricoes (
                    recomendacoes,
                    id_prontuario)
                VALUES (?, ?)
            ");
            $stmt->execute([
                $prontuario->getPrescricao()->getRecomendacoes(),
                $prontuario->getPrescricao()->getIdProntuario()
            ]);

            // Recupera o ID gerado da prescrição
            $idPrescricao = $this->conn->lastInsertId();
            $prontuario->getPrescricao()->setIdPrescricao($idPrescricao);

            //Salvar a lista de medicamentos da prescricao
            foreach ($listaMedicamentos as $medicamento) {
                $stmt = $this->conn->prepare("
                    INSERT INTO medicamentos (
                        nome_medicamento,
                        concentracao,
                        forma_farmaceutica,
                        via_administracao,
                        tipo_receita,
                        intervalo_dose,
                        frequencia_dose,
                        turno_dose,
                        data_inicio,
                        quantidade_duracao,
                        tipo_duracao,
                        id_prescricao
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $stmt->execute([
                    $medicamento->getNomeMedicamento(),
                    $medicamento->getConcentracao(),
                    $medicamento->getFormaFarmaceutica(),
                    $medicamento->getViaAdministracao(),
                    $medicamento->getTipoReceita(),
                    $medicamento->getIntervaloDose(),
                    $medicamento->getFrequenciaDose(),
                    $medicamento->getTurnoDose(),
                    $medicamento->getDataInicio(),
                    $medicamento->getQuantidadeDuracao(),
                    $medicamento->getTipoDuracao(),
                    $idPrescricao
                ]);
            }

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

            $idDocumentacao = $this->conn->lastInsertId();

            //Salvar o atestado
            $atestado = $prontuario->getDocumentacao()->getAtestado();
            $tipo = ''; // Vamos definir o tipo com base na classe

            if ($atestado instanceof AtestadoAcompanhante) {
                $tipo = 'acompanhante';
            } elseif ($atestado instanceof AtestadoAfastamento) {
                $tipo = 'afastamento';
            } elseif ($atestado instanceof AtestadoComparecimento) {
                $tipo = 'comparecimento';
            }

            // Atribui o ID da documentação ao atestado
            $atestado->setIdDocumentacao($idDocumentacao);

            $stmt = $this->conn->prepare("
                INSERT INTO atestados (
                    cid10,
                    texto_principal,
                    id_documentacao
                ) VALUES (?, ?, ?)
            ");
            $stmt->execute([
                $atestado->getCid10(),
                $atestado->getTextoPrincipal(),
                $atestado->getIdDocumentacao()
            ]);

            $idAtestado = $this->conn->lastInsertId();

            //Salvar o atestado acompanhante
            if ($tipo === 'acompanhante') {
                $stmt = $this->conn->prepare("
                    INSERT INTO atestados_acompanhante (
                        nome_acompanhante,
                        cpf_acompanhante,
                        parentesco_acompanhante,
                        data,
                        horario_chegada,
                        horario_saida,
                        id_atestado
                    ) VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $atestadoObj->getNomeAcompanhante(),
                    $atestadoObj->getCpfAcompanhante(),
                    $atestadoObj->getParentescoAcompanhante(),
                    $atestadoObj->getData(),
                    $atestadoObj->getHorarioChegada(),
                    $atestadoObj->getHorarioSaida(),
                    $idAtestado
                ]);
            }

            //Salvar o atestado afastamento
            if ($tipo === 'afastamento') {
                $stmt = $this->conn->prepare("
                    INSERT INTO atestados_afastamento (
                        dias_afastamento,
                        data_inicio,
                        data_retorno,
                        id_atestado
                    ) VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([
                    $atestadoObj->getDiasAfastamento(),
                    $atestadoObj->getDataInicio(),
                    $atestadoObj->getDataRetorno(),
                    $idAtestado
                ]);
            }

            //Salvar o atestado comparecimento
            if ($tipo === 'comparecimento') {
                $stmt = $this->conn->prepare("
                    INSERT INTO atestados_comparecimento (
                        data,
                        horario_chegada,
                        horario_saida,
                        id_atestado
                    ) VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([
                    $atestadoObj->getData(),
                    $atestadoObj->getHorarioChegada(),
                    $atestadoObj->getHorarioSaida(),
                    $idAtestado
                ]);
            }

            //SALVAR O HISTORICO DE CONSULTAS AQUI --- DESCOBRIR COMO IMPLEMENTAR

            //FINALIZAR A CONSULTA
            $controller = new ConsultaController();
            $controller->finalizarConsulta();

        } catch (Exception $e) {
            echo "Erro ao salvar o prontuário: " . $e->getMessage();
        }
    }
}
