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
            // Converter JSON para objetos Medicamento
            $listaMedicamentos = [];

            if (!empty($_POST['medicamentosJSON'])) {
                $medicamentosArray = json_decode($_POST['medicamentosJSON'], true);

                if (is_array($medicamentosArray)) {
                    foreach ($medicamentosArray as $med) {
                        $medicamento = new Medicamento(
                            idMedicamento: 0,
                            nomeMedicamento: $med['principioAtivo'] ?? '',
                            concentracao: $med['concentracao'] ?? '',
                            formaFarmaceutica: $med['forma'] ?? '',
                            viaAdministracao: $med['via'] ?? '',
                            tipoReceita: $med['tipoReceita'] ?? '',
                            intervaloDose: $med['intervalo'] ?? '',
                            frequenciaDose: $med['frequencia'] ?? '',
                            turnoDose: $med['turno'] ?? '',
                            dataInicio: $med['inicioTratamento'] ?? '',
                            quantidadeDuracao: $med['duracao'] ?? '',
                            tipoDuracao: $med['duracaoTipo'] ?? '',
                            idPrescricao: null
                        );
                        $listaMedicamentos[] = $medicamento;
                    }
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
                dataCriacao: $_SESSION['data_criacao'],
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
                doencasNotificacaoObrigatoria: $_POST['notificacoesObrigatorias'],
                observacoesAdicionais: $_POST['obsMedicas'],
                idPaciente: $_SESSION['paciente_id'],
                idMedico: $_SESSION['medico_id'],
                idConsulta: $_SESSION['consulta_id'],
                nomeMedico: null
            );
            
            $stmt = $this->conn->prepare("
                INSERT INTO prontuarios ( 
                    data_criacao, 
                    diagnostico_presuntivo, 
                    diagnostico_diferencial,
                    diagnostico_definitivo,
                    cid10,
                    evolucao,
                    doencas_notificacao_obrigatoria,
                    observacoes_adicionais,
                    id_paciente,
                    id_medico,
                    id_consulta
                    )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $prontuario->getDataCriacao(),
                $prontuario->getDiagnosticoPresuntivo(),
                $prontuario->getDiagnosticoDiferencial(),
                $prontuario->getDiagnosticoDefinitivo(),
                $prontuario->getCid10(),
                $prontuario->getEvolucao(),
                $prontuario->getDoencasNotificacaoObrigatoria(),
                $prontuario->getObservacoesAdicionais(),
                $prontuario->getIdPaciente(),
                $prontuario->getIdMedico(),
                $prontuario->getIdConsulta()
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

            //Salvar internações
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

            $idDocumentacao = $this->conn->lastInsertId();

            // Obtem o atestado
            $atestado = $prontuario->getDocumentacao()->getAtestado();
            
            // Se não há atestado, pula toda a lógica de salvamento
            if ($atestado !== null) {

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
            }

            

            //FINALIZAR A CONSULTA
            $controller = new ConsultaController();
            $controller->finalizarConsulta();

        } catch (Exception $e) {
            echo "Erro ao salvar o prontuário: " . $e->getMessage();
        }
    }

    public function visualizarProntuario($idConsulta) {
        try {
            $sqlProntuario = "
                SELECT p.*
                FROM prontuarios p
                JOIN consultas c ON p.id_consulta = c.id
                WHERE c.status = 'Realizada' AND p.id_consulta = :id_consulta
            ";
            $stmtProntuario = $this->conn->prepare($sqlProntuario);
            $stmtProntuario->execute([':id_consulta' => $idConsulta]);
            $dataProntuario = $stmtProntuario->fetch(PDO::FETCH_ASSOC);

            if (!$dataProntuario) {
            return null;
            }

            $idProntuario = $dataProntuario['id_prontuario'];

            // Buscar histórico médico
            $sqlHistoricoMedico = "SELECT * FROM historicos_medicos WHERE id_prontuario = :id_prontuario";
            $stmtHistoricoMedico = $this->conn->prepare($sqlHistoricoMedico);
            $stmtHistoricoMedico->execute([':id_prontuario' => $idProntuario]);
            $dataHistoricoMedico = $stmtHistoricoMedico->fetch(PDO::FETCH_ASSOC);
            $historicoMedico = null;
            if($dataHistoricoMedico) {
                $historicoMedico = new HistoricoMedico(
                    $dataHistoricoMedico['doencas_preexistentes'],
                    $dataHistoricoMedico['medicacoes_uso_continuo'],
                    $dataHistoricoMedico['cirurgias_anteriores'],
                    $dataHistoricoMedico['alergias_medicamentos'],
                    $dataHistoricoMedico['historico_doencas_familia'],
                    $idProntuario
                );
            }
            
            // Buscar anamnese
            $sqlAnamnese = "SELECT * FROM anamneses WHERE id_prontuario = :id_prontuario";
            $stmtAnamnese = $this->conn->prepare($sqlAnamnese);
            $stmtAnamnese->execute([':id_prontuario' => $idProntuario]);
            $dataAnamnese = $stmtAnamnese->fetch(PDO::FETCH_ASSOC);           
            $anamnese = null;
            if ($dataAnamnese) {
                $anamnese = new Anamnese(
                    $dataAnamnese['motivo_consulta'],
                    $dataAnamnese['queixa_duracao'],
                    $dataAnamnese['historia_doenca_atual'],
                    $dataAnamnese['historia_social'],
                    $dataAnamnese['historia_gineco_obstetrica'],
                    $dataAnamnese['revisao_sistemas'],
                    $dataAnamnese['fatores_agravantes'],
                    $dataAnamnese['atenuantes'],
                    $dataAnamnese['tratamentos_previos'],
                    $dataAnamnese['resposta_tratamentos_previos'],
                    $idProntuario
                );
            }

            // Buscar exame físico
            $sqlExameFisico = "SELECT * FROM exames_fisicos WHERE id_prontuario = :id_prontuario";
            $stmtExameFisico = $this->conn->prepare($sqlExameFisico);
            $stmtExameFisico->execute([':id_prontuario' => $idProntuario]);
            $dataExameFisico = $stmtExameFisico->fetch(PDO::FETCH_ASSOC);           
            $exameFisico = null;
            if ($dataExameFisico) {
                $exameFisico = new ExameFisico(
                    $dataExameFisico['avaliacao_geral'],
                    $dataExameFisico['sinais_vitais'],
                    $dataExameFisico['exame_pele_anexos'],
                    $dataExameFisico['exame_cabeca_pescoco'],
                    $dataExameFisico['exame_cardiovascular'],
                    $dataExameFisico['exame_respiratorio'],
                    $dataExameFisico['exame_abdominal'],
                    $dataExameFisico['exame_neurologico'],
                    $dataExameFisico['exame_aparelho_locomotor'],
                    $idProntuario
                );
            }

            // Buscar exames solicitados
            $sqlExames = "SELECT * FROM exames WHERE id_prontuario = :id_prontuario";
            $stmtExames = $this->conn->prepare($sqlExames);
            $stmtExames->execute([':id_prontuario' => $idProntuario]);
            $dataExames = $stmtExames->fetchAll(PDO::FETCH_ASSOC);     
            $listaExames = [];
            if ($dataExames) {
                foreach ($dataExames as $ex) {
                    $exame = new Exame(
                        $ex['id_exame'],
                        $ex['nome'],
                        $idProntuario
                    );
                    $listaExames[] = $exame;
                }         
            }

            // Buscar prescrição
            $sqlPrescricao = "SELECT * FROM prescricoes WHERE id_prontuario = :id_prontuario";
            $stmtPrescricao = $this->conn->prepare($sqlPrescricao);
            $stmtPrescricao->execute([':id_prontuario' => $idProntuario]);
            $dataPrescricao = $stmtPrescricao->fetch(PDO::FETCH_ASSOC);           
            $prescricao = null;
            if ($dataPrescricao) {
                $prescricao = new Prescricao(
                    $dataPrescricao['id_prescricao'],
                    $medicamentos = [],
                    $dataPrescricao['recomendacoes'],
                    $idProntuario
                );
            }
            $idPrescricao = $dataPrescricao['id_prescricao'];

            // Buscar medicamentos
            $sqlMedicamentos = "SELECT * FROM medicamentos WHERE id_prescricao = :id_prescricao";
            $stmtMedicamentos = $this->conn->prepare($sqlMedicamentos);
            $stmtMedicamentos->execute([':id_prescricao' => $idPrescricao]);
            $dataMedicamentos = $stmtMedicamentos->fetchAll(PDO::FETCH_ASSOC);           
            $listaMedicamentos = [];
            if ($dataMedicamentos) {
                foreach ($dataMedicamentos as $med) {
                    $medicamento = new Medicamento(
                        $med['id_medicamento'],
                        $med['nome_medicamento'],
                        $med['concentracao'],
                        $med['forma_farmaceutica'],
                        $med['via_administracao'],
                        $med['tipo_receita'],
                        $med['intervalo_dose'],
                        $med['frequencia_dose'],
                        $med['turno_dose'],
                        $med['data_inicio'],
                        $med['quantidade_duracao'],
                        $med['tipo_duracao'],
                        $idPrescricao
                    );
                    $listaMedicamentos[] = $medicamento;
                }
            }

            // Buscar internação
            $sqlInternacao = "SELECT * FROM internacoes WHERE id_prontuario = :id_prontuario";
            $stmtInternacao = $this->conn->prepare($sqlInternacao);
            $stmtInternacao->execute([':id_prontuario' => $idProntuario]);
            $dataInternacao = $stmtInternacao->fetch(PDO::FETCH_ASSOC);           
            $internacao = null;
            if ($dataInternacao) {
                $internacao = new Internacao(
                    $dataInternacao['data_admissao_e_alta'],
                    $dataInternacao['diagnostico_internacao'],
                    $dataInternacao['procedimentos_cirurgicos'],
                    $dataInternacao['medicos_responsaveis'],
                    $idProntuario
                );
            }

            // Buscar documentação
            $sqlDocumentacao = "SELECT * FROM documentacoes WHERE id_prontuario = :id_prontuario";
            $stmtDocumentacao = $this->conn->prepare($sqlDocumentacao);
            $stmtDocumentacao->execute([':id_prontuario' => $idProntuario]);
            $dataDocumentacao = $stmtDocumentacao->fetch(PDO::FETCH_ASSOC);           
            $documentacao = null;
            if ($dataDocumentacao) {
                $documentacao = new Documentacao(
                    $dataDocumentacao['id_documentacao'],
                    $dataDocumentacao['termos_consentimento'],
                    null,
                    $dataDocumentacao['declaracao_saude'],
                    $idProntuario
                );
            }
            $idDocumentacao = $dataDocumentacao['id_documentacao'];

            // Buscar atestado
            $idAtestado = null;
            $atestadoAcompanhante = null;
            $atestadoAfastamento = null;
            $atestadoComparecimento = null;
            $sqlAtestado = "SELECT * FROM atestados WHERE id_documentacao = :id_documentacao";
            $stmtAtestado = $this->conn->prepare($sqlAtestado);
            $stmtAtestado->execute([':id_documentacao' => $idDocumentacao]);
            $dataAtestado = $stmtAtestado->fetch(PDO::FETCH_ASSOC);           
            $atestado = null;
            if ($dataAtestado) {
                $atestado = new Atestado(
                    $dataAtestado['id_atestado'],
                    $dataAtestado['cid10'],
                    $dataAtestado['texto_principal'],
                    $idDocumentacao
                );
                $idAtestado = $dataAtestado['id_atestado'];
            }      

            //Buscar atestado de acompanhante
            if ($idAtestado !== null) {
                $sqlAtestadoAcompanhante = "SELECT * FROM atestados_acompanhante WHERE id_atestado = :id_atestado";
                $stmtAtestadoAcompanhante = $this->conn->prepare($sqlAtestadoAcompanhante);
                $stmtAtestadoAcompanhante->execute([':id_atestado' => $idAtestado]); 
                $dataAtestadoAcompanhante = $stmtAtestadoAcompanhante->fetch(PDO::FETCH_ASSOC);           
                $atestadoAcompanhante = null;
                if ($dataAtestadoAcompanhante) {
                    $atestadoAcompanhante = new AtestadoAcompanhante(
                        $atestado->getIdAtestado(),
                        $atestado->getCid10(),
                        $atestado->getTextoPrincipal(),
                        $atestado->getIdDocumentacao(),
                        $dataAtestadoAcompanhante['nome_acompanhante'],
                        $dataAtestadoAcompanhante['cpf_acompanhante'],
                        $dataAtestadoAcompanhante['parentesco_acompanhante'],
                        $dataAtestadoAcompanhante['data'],
                        $dataAtestadoAcompanhante['horario_chegada'],
                        $dataAtestadoAcompanhante['horario_saida'],
                        
                    );
                }
            }

            //Buscar atestado de afastamento
            if ($idAtestado !== null) {
                $sqlAtestadoAfastamento = "SELECT * FROM atestados_afastamento WHERE id_atestado = :id_atestado";
                $stmtAtestadoAfastamento = $this->conn->prepare($sqlAtestadoAfastamento);
                $stmtAtestadoAfastamento->execute([':id_atestado' => $idAtestado]); 
                $dataAtestadoAfastamento = $stmtAtestadoAfastamento->fetch(PDO::FETCH_ASSOC);           
                $atestadoAfastamento = null;
                if ($dataAtestadoAfastamento) {
                    $atestadoAfastamento = new AtestadoAfastamento(
                        $atestado->getIdAtestado(),
                        $atestado->getCid10(),
                        $atestado->getTextoPrincipal(),
                        $atestado->getIdDocumentacao(),
                        $dataAtestadoAfastamento['dias_afastamento'],
                        $dataAtestadoAfastamento['data_inicio'],
                        $dataAtestadoAfastamento['data_retorno'],
                        $idAtestado
                    );
                }
            }

            //Buscar atestado de comparecimento
            if ($idAtestado !== null) {
                $sqlAtestadoComparecimento = "SELECT * FROM atestados_comparecimento WHERE id_atestado = :id_atestado";
                $stmtAtestadoComparecimento = $this->conn->prepare($sqlAtestadoComparecimento);
                $stmtAtestadoComparecimento->execute([':id_atestado' => $idAtestado]); 
                $dataAtestadoComparecimento = $stmtAtestadoComparecimento->fetch(PDO::FETCH_ASSOC);           
                $atestadoComparecimento = null;
                if ($dataAtestadoComparecimento) {
                    $atestadoComparecimento = new AtestadoComparecimento(
                        $atestado->getIdAtestado(),
                        $atestado->getCid10(),
                        $atestado->getTextoPrincipal(),
                        $atestado->getIdDocumentacao(),
                        $dataAtestadoComparecimento['data'],
                        $dataAtestadoComparecimento['horario_chegada'],
                        $dataAtestadoComparecimento['horario_saida'],
                        $idAtestado
                    );
                }
            }
            
            $prontuario =  new Prontuario(
                $dataProntuario['id_prontuario'],
                $dataProntuario['data_criacao'],
                $historicoMedico,
                $anamnese,
                $exameFisico,
                $dataProntuario['diagnostico_presuntivo'],
                $dataProntuario['diagnostico_diferencial'],
                $dataProntuario['diagnostico_definitivo'],
                $dataProntuario['cid10'],
                $listaExames,
                $prescricao,
                $dataProntuario['evolucao'],
                $internacao,
                $documentacao,
                $dataProntuario['doencas_notificacao_obrigatoria'],
                $dataProntuario['observacoes_adicionais'],
                $dataProntuario['id_paciente'],
                $dataProntuario['id_medico'],
                $dataProntuario['id_consulta'],
                null
            );

            $prescricao->setMedicamentos($listaMedicamentos);

            if ($atestadoAcompanhante) { 
                $documentacao->setAtestado($atestadoAcompanhante);
            } elseif ($atestadoAfastamento) {
                $documentacao->setAtestado($atestadoAfastamento);
            } elseif ($atestadoComparecimento) { 
                $documentacao->setAtestado($atestadoComparecimento);
            } 

            return $prontuario;

        } catch (Exception $e) {
            echo "Erro ao visualizar o prontuário: " . $e->getMessage();
            return null;
        }
    }

    public function atualizarProntuario(int $idProntuario) {
        try {
            // Converter JSON para objetos Medicamento
            $listaMedicamentos = [];

            if (!empty($_POST['medicamentosJSON'])) {
                $medicamentosArray = json_decode($_POST['medicamentosJSON'], true);

                if (is_array($medicamentosArray)) {
                    foreach ($medicamentosArray as $med) {
                        $medicamento = new Medicamento(
                            idMedicamento: $med['id_medicamento'],
                            nomeMedicamento: $med['nome_medicamento'] ?? '',
                            concentracao: $med['concentracao'] ?? '',
                            formaFarmaceutica: $med['forma_farmaceutica'] ?? '',
                            viaAdministracao: $med['via_administracao'] ?? '',
                            tipoReceita: $med['tipo_receita'] ?? '',
                            intervaloDose: $med['intervalo_dose'] ?? '',
                            frequenciaDose: $med['frequencia_dose'] ?? '',
                            turnoDose: $med['turno_dose'] ?? '',
                            dataInicio: $med['data_inicio'] ?? '',
                            quantidadeDuracao: $med['quantidade_duracao'] ?? '',
                            tipoDuracao: $med['tipo_duracao'] ?? '',
                            idPrescricao: $med['id_prescricao']
                        );
                        $listaMedicamentos[] = $medicamento;
                    }
                }
            }

            //Transformar o examesJson em objetos
            $listaExames = [];
            if(isset($_POST['examesJSON'])) {
                $examesArray = json_decode($_POST['examesJSON'], true);

                foreach ($examesArray as $ex) {
                    $exame = new Exame(
                        idExame: $ex['idExame'],
                        nomeExame: $ex['nomeExame'],
                        idProntuario: $ex['idProntuario']
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
                                idAtestado: $atestadoData['idAtestado'],
                                cid10: $atestadoData['cid10'],
                                textoPrincipal: $atestadoData['textoPrincipal'],
                                idDocumentacao: $atestadoData['idDocumentacao'],
                                diasAfastamento: $atestadoData['diasAfastamento'],
                                dataInicio: $atestadoData['dataInicio'],
                                dataRetorno: $atestadoData['dataRetorno']                                                              
                            );
                            break;

                        case 'comparecimento':
                            $atestadoObj = new AtestadoComparecimento(
                                idAtestado: $atestadoData['idAtestado'],
                                cid10: $atestadoData['cid10'],
                                textoPrincipal: $atestadoData['textoPrincipal'],
                                idDocumentacao: $atestadoData['idDocumentacao'],
                                data: $atestadoData['data'],
                                horarioChegada: $atestadoData['horarioChegada'],
                                horarioSaida: $atestadoData['horarioSaida']
                            );
                            break;

                        case 'acompanhante':
                            $atestadoObj = new AtestadoAcompanhante(
                                idAtestado: $atestadoData['id_atestado'],
                                cid10: $atestadoData['cid10'],
                                textoPrincipal: $atestadoData['textoPrincipal'],
                                idDocumentacao: $atestadoData['idDocumentacao'],
                                nomeAcompanhante: $atestadoData['nomeAcompanhante'],
                                cpfAcompanhante: $atestadoData['cpfAcompanhante'],
                                parentescoAcompanhante: $atestadoData['parentescoAcompanhante'],
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
                idProntuario: $_POST['id_prontuario'],
                dataCriacao: $_SESSION['data_criacao'],
                historicoMedico: new HistoricoMedico(
                    $_POST['doencasPreExistentes'],
                    $_POST['medicacoesUsoContinuo'],
                    $_POST['cirurgiasAnteriores'],
                    $_POST['alergias'],
                    $_POST['doencasFamilia'],
                    $_POST['id_prontuario'] //AQUI ESTÁ O ID QUE VEIO DO FORM
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
                    $_POST['id_prontuario']
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
                    $_POST['id_prontuario']
                ),
                diagnosticoPresuntivo: $_POST['diagPresuntivo'],
                diagnosticoDiferencial: $_POST['diagDiferencial'],
                diagnosticoDefinitivo: $_POST['diagDefinitivo'],
                cid10: $_POST['cid10'],
                examesSolicitados: $listaExames,
                prescricao: new Prescricao(
                    $_POST['id_prescricao'],
                    $listaMedicamentos, //MEDICAMENTOS
                    $recomendacoes, //RECOMENDAÇÕES
                    $_POST['id_prontuario']
                ),
                evolucao: $_POST['evolucao'],
                internacao: new Internacao(
                    $_POST['dataAdmissaoAlta'],
                    $_POST['diagInternacao'],
                    $_POST['cirurgiasInternacao'],
                    $_POST['medicosInternacao'],
                    $_POST['id_prontuario']
                ),
                documentacao: new Documentacao(
                    $_POST['id_documentacao'],
                    $_POST['termosConsentimento'],
                    $atestadoObj,
                    $_POST['declaracoesSaude'],
                    $_POST['id_prontuario']
                ),
                doencasNotificacaoObrigatoria: $_POST['notificacoesObrigatorias'],
                observacoesAdicionais: $_POST['obsMedicas'],
                idPaciente: $_SESSION['paciente_id'],
                idMedico: $_SESSION['medico_id'],
                idConsulta: $_SESSION['consulta_id'],
                nomeMedico: null
            );

            //CONSULTA SQL
            $stmt = $this->conn->prepare("
                UPDATE prontuarios SET
                    data_criacao = ?,
                    diagnostico_presuntivo = ?,
                    diagnostico_diferencial = ?,
                    diagnostico_definitivo = ?,
                    cid10 = ?,
                    evolucao = ?,
                    doencas_notificacao_obrigatoria = ?,
                    observacoes_adicionais = ?
                WHERE id_prontuario = ?
            ");

            $stmt->execute([
                $prontuario->getDataCriacao(),
                $prontuario->getDiagnosticoPresuntivo(),
                $prontuario->getDiagnosticoDiferencial(),
                $prontuario->getDiagnosticoDefinitivo(),
                $prontuario->getCid10(),
                $prontuario->getEvolucao(),
                $prontuario->getDoencasNotificacaoObrigatoria(),
                $prontuario->getObservacoesAdicionais(),
                $prontuario->getIdProntuario() // <- aqui entra o ID do prontuário para o WHERE
            ]);

            $stmt = $this->conn->prepare("
                UPDATE historicos_medicos SET
                    doencas_preexistentes = ?,
                    medicacoes_uso_continuo = ?,
                    cirurgias_anteriores = ?,
                    alergias_medicamentos = ?,
                    historico_doencas_familia = ?
                WHERE id_prontuario = ?
            ");

            $stmt->execute([
                $prontuario->getHistoricoMedico()->getDoencasPreexistentes(),
                $prontuario->getHistoricoMedico()->getMedicacoesUsoContinuo(),
                $prontuario->getHistoricoMedico()->getCirurgiasAnteriores(),
                $prontuario->getHistoricoMedico()->getAlergiasMedicamentos(),
                $prontuario->getHistoricoMedico()->getHistoricoDoencasFamilia(),
                $prontuario->getIdProntuario()
            ]);

            //Salvar a Anamnese
            $stmt = $this->conn->prepare("
                UPDATE anamneses SET 
                    motivo_consulta = ?,
                    queixa_duracao = ?,
                    historia_doenca_atual = ?,
                    historia_social = ?,
                    historia_gineco_obstetrica = ?,
                    revisao_sistemas = ?,
                    fatores_agravantes = ?,
                    atenuantes = ?,
                    tratamentos_previos = ?,
                    resposta_tratamentos_previos = ?
                WHERE id_prontuario = ?
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
                $prontuario->getIdProntuario()
            ]);

            //Salvar o Exame Físico
            $stmt = $this->conn->prepare("
                UPDATE exames_fisicos SET 
                    avaliacao_geral = ?,
                    sinais_vitais = ?,
                    exame_pele_anexos = ?,
                    exame_cabeca_pescoco = ?,
                    exame_cardiovascular = ?,
                    exame_respiratorio = ?,
                    exame_abdominal = ?,
                    exame_neurologico = ?,
                    exame_aparelho_locomotor = ?
                WHERE id_prontuario = ?
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
                $prontuario->getIdProntuario()
            ]);

            //salvar a lista com o nome dos exames solicitados
            // Atualiza os exames existentes
            foreach ($listaExames as $exame) {
                $stmt = $this->conn->prepare("
                    UPDATE exames SET 
                        nome = ?
                    WHERE id_exame = ?
                ");
                $stmt->execute([
                    $exame->getNomeExame(),
                    $exame->getIdExame()
                ]);
            }

            // Remove exames que não estão mais na lista
            $idsParaManter = array_map(function($exame) {
                return $exame->getIdExame();
            }, $listaExames);

            // Se houver exames para manter, exclui os demais
            if (!empty($idsParaManter)) {
                $placeholders = implode(',', array_fill(0, count($idsParaManter), '?'));
                $sql = "
                    DELETE FROM exames 
                    WHERE id_prontuario = ? 
                    AND id_exame NOT IN ($placeholders)
                ";

                // Junta o ID do prontuário com os IDs a manter
                $params = array_merge([$prontuario->getIdProntuario()], $idsParaManter);
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($params);
            } else {
                // Se a lista está vazia, remove todos os exames do prontuário
                $stmt = $this->conn->prepare("DELETE FROM exames WHERE id_prontuario = ?");
                $stmt->execute([$prontuario->getIdProntuario()]);
            }

            //Salvar a prescricao
            $stmt = $this->conn->prepare("
                UPDATE prescricoes SET 
                    recomendacoes = ?
                WHERE id_prontuario = ?
            ");
            $stmt->execute([
                $prontuario->getPrescricao()->getRecomendacoes(),
                $prontuario->getIdProntuario()
            ]);

            //Salvar a lista de medicamentos da prescricao
            // Atualiza os medicamentos existentes da prescrição
            foreach ($listaMedicamentos as $medicamento) {
                $stmt = $this->conn->prepare("
                    UPDATE medicamentos SET
                        nome_medicamento = ?,
                        concentracao = ?,
                        forma_farmaceutica = ?,
                        via_administracao = ?,
                        tipo_receita = ?,
                        intervalo_dose = ?,
                        frequencia_dose = ?,
                        turno_dose = ?,
                        data_inicio = ?,
                        quantidade_duracao = ?,
                        tipo_duracao = ?
                    WHERE id_medicamento = ?
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
                    $medicamento->getIdMedicamento()
                ]);
            }

            // Excluir medicamentos que não estão mais na lista
            $idsParaManter = array_map(function($medicamento) {
                return $medicamento->getIdMedicamento();
            }, $listaMedicamentos);

            // Se houver medicamentos para manter
            if (!empty($idsParaManter)) {
                $placeholders = implode(',', array_fill(0, count($idsParaManter), '?'));

                $sql = "
                    DELETE FROM medicamentos 
                    WHERE id_prescricao = ? 
                    AND id_medicamento NOT IN ($placeholders)
                ";

                $params = array_merge([$prontuario->getPrescricao()->getIdPrescricao()], $idsParaManter);

                $stmt = $this->conn->prepare($sql);
                $stmt->execute($params);
            } else {
                // Remove todos os medicamentos da prescrição, se a lista estiver vazia
                $stmt = $this->conn->prepare("DELETE FROM medicamentos WHERE id_prescricao = ?");
                $stmt->execute([$prontuario->getPrescricao()->getIdPrescricao()]);
            }

            //Salvar internações
            $stmt = $this->conn->prepare("
                UPDATE internacoes SET
                    data_admissao_e_alta = ?,
                    diagnostico_internacao = ?,
                    procedimentos_cirurgicos = ?,
                    medicos_responsaveis = ?
                WHERE id_prontuario = ?
            ");
            $stmt->execute([
                $prontuario->getInternacao()->getDataAdmissaoEAlta(),
                $prontuario->getInternacao()->getDiagnosticoInternacao(),
                $prontuario->getInternacao()->getProcedimentosCirurgicos(),
                $prontuario->getInternacao()->getMedicosResponsaveis(),
                $prontuario->getIdProntuario()
            ]);

            //Salvar documentação
            $stmt = $this->conn->prepare("
                UPDATE documentacoes SET
                    termos_consentimento = ?,
                    declaracao_saude = ?
                WHERE id_prontuario = ?
            ");
            $stmt->execute([
                $prontuario->getDocumentacao()->getTermosConsentimento(),
                $prontuario->getDocumentacao()->getDeclaracoesSaude(),
                $prontuario->getIdProntuario()
            ]);

            // Obtem o atestado
            $atestado = $prontuario->getDocumentacao()->getAtestado();
            
            // Se não há atestado, pula toda a lógica de salvamento
            if ($atestado !== null) {

                $tipo = ''; // Vamos definir o tipo com base na classe

                if ($atestado instanceof AtestadoAcompanhante) {
                    $tipo = 'acompanhante';
                } elseif ($atestado instanceof AtestadoAfastamento) {
                    $tipo = 'afastamento';
                } elseif ($atestado instanceof AtestadoComparecimento) {
                    $tipo = 'comparecimento';
                }

                // Atualiza os dados do atestado (tabela principal)
                $stmt = $this->conn->prepare("
                    UPDATE atestados SET
                        cid10 = ?,
                        texto_principal = ?
                    WHERE id_atestado = ?
                ");
                $stmt->execute([
                    $atestado->getCid10(),
                    $atestado->getTextoPrincipal(),
                    $atestado->getIdAtestado()
                ]);

                // Limpeza de tipos antigos que não correspondem ao tipo atual
                if ($tipo === 'acompanhante') {
                    $this->conn->prepare("DELETE FROM atestados_afastamento WHERE id_atestado = ?")->execute([$atestado->getIdAtestado()]);
                    $this->conn->prepare("DELETE FROM atestados_comparecimento WHERE id_atestado = ?")->execute([$atestado->getIdAtestado()]);
                }

                if ($tipo === 'afastamento') {
                    $this->conn->prepare("DELETE FROM atestados_acompanhante WHERE id_atestado = ?")->execute([$atestado->getIdAtestado()]);
                    $this->conn->prepare("DELETE FROM atestados_comparecimento WHERE id_atestado = ?")->execute([$atestado->getIdAtestado()]);
                }

                if ($tipo === 'comparecimento') {
                    $this->conn->prepare("DELETE FROM atestados_acompanhante WHERE id_atestado = ?")->execute([$atestado->getIdAtestado()]);
                    $this->conn->prepare("DELETE FROM atestados_afastamento WHERE id_atestado = ?")->execute([$atestado->getIdAtestado()]);
                }

                //Salvar o atestado acompanhante
                if ($tipo === 'acompanhante') {
                    $stmt = $this->conn->prepare("
                        UPDATE atestados_acompanhante SET
                            nome_acompanhante = ?,
                            cpf_acompanhante = ?,
                            parentesco_acompanhante = ?,
                            data = ?,
                            horario_chegada = ?,
                            horario_saida = ?
                        WHERE id_atestado = ?
                    ");
                    $stmt->execute([
                        $atestado->getNomeAcompanhante(),
                        $atestado->getCpfAcompanhante(),
                        $atestado->getParentescoAcompanhante(),
                        $atestado->getData(),
                        $atestado->getHorarioChegada(),
                        $atestado->getHorarioSaida(),
                        $atestado->getIdAtestado()
                    ]);
                }

                //Salvar o atestado afastamento
                if ($tipo === 'afastamento') {
                    $stmt = $this->conn->prepare("
                        UPDATE atestados_afastamento SET
                            dias_afastamento = ?,
                            data_inicio = ?,
                            data_retorno = ?
                        WHERE id_atestado = ?
                    ");
                    $stmt->execute([
                        $atestado->getDiasAfastamento(),
                        $atestado->getDataInicio(),
                        $atestado->getDataRetorno(),
                        $atestado->getIdAtestado()
                    ]);
                }

                //Salvar o atestado comparecimento
                if ($tipo === 'comparecimento') {
                    $stmt = $this->conn->prepare("
                        UPDATE atestados_comparecimento SET
                            data = ?,
                            horario_chegada = ?,
                            horario_saida = ?
                        WHERE id_atestado = ?
                    ");
                    $stmt->execute([
                        $atestado->getData(),
                        $atestado->getHorarioChegada(),
                        $atestado->getHorarioSaida(),
                        $atestado->getIdAtestado()
                    ]);
                }
            }

            // Redireciona para a tela dos atendimentos do dia
            header("Location: ../views/atendimentos-dia.php");
            exit;

        } catch (Exception $e) {
            echo "Erro ao atualizar o prontuário: " . $e->getMessage();
        }
    }

    public function listarProntuarios($idPaciente): array {

        try {
            $sqlProntuario = "SELECT 
                                    p.*, 
                                    u.nome AS nome_medico
                                FROM 
                                    prontuarios p
                                INNER JOIN 
                                    medicos m ON p.id_medico = m.id_medico
                                INNER JOIN 
                                    usuarios u ON m.id_usuario = u.id_usuario
                                WHERE 
                                    p.id_paciente = :id_paciente";
            $stmtProntuario = $this->conn->prepare($sqlProntuario);
            $stmtProntuario->execute([':id_paciente' => $idPaciente]);
            $dataProntuarios = $stmtProntuario->fetchAll(PDO::FETCH_ASSOC);

            if (!$dataProntuarios) {
                return [];
            }

            $prontuarios = [];

            foreach ($dataProntuarios as $row) {
                $idProntuario = $row['id_prontuario'];
                $nomeMedico = $row['nome_medico'];

                // Buscar histórico médico
                $sqlHistoricoMedico = "SELECT * FROM historicos_medicos WHERE id_prontuario = :id_prontuario";
                $stmtHistoricoMedico = $this->conn->prepare($sqlHistoricoMedico);
                $stmtHistoricoMedico->execute([':id_prontuario' => $idProntuario]);
                $dataHistoricoMedico = $stmtHistoricoMedico->fetch(PDO::FETCH_ASSOC);
                $historicoMedico = null;
                if($dataHistoricoMedico) {
                    $historicoMedico = new HistoricoMedico(
                        $dataHistoricoMedico['doencas_preexistentes'],
                        $dataHistoricoMedico['medicacoes_uso_continuo'],
                        $dataHistoricoMedico['cirurgias_anteriores'],
                        $dataHistoricoMedico['alergias_medicamentos'],
                        $dataHistoricoMedico['historico_doencas_familia'],
                        $idProntuario
                    );
                }

                // Buscar anamnese
                $sqlAnamnese = "SELECT * FROM anamneses WHERE id_prontuario = :id_prontuario";
                $stmtAnamnese = $this->conn->prepare($sqlAnamnese);
                $stmtAnamnese->execute([':id_prontuario' => $idProntuario]);
                $dataAnamnese = $stmtAnamnese->fetch(PDO::FETCH_ASSOC);           
                $anamnese = null;
                if ($dataAnamnese) {
                    $anamnese = new Anamnese(
                        $dataAnamnese['motivo_consulta'],
                        $dataAnamnese['queixa_duracao'],
                        $dataAnamnese['historia_doenca_atual'],
                        $dataAnamnese['historia_social'],
                        $dataAnamnese['historia_gineco_obstetrica'],
                        $dataAnamnese['revisao_sistemas'],
                        $dataAnamnese['fatores_agravantes'],
                        $dataAnamnese['atenuantes'],
                        $dataAnamnese['tratamentos_previos'],
                        $dataAnamnese['resposta_tratamentos_previos'],
                        $idProntuario
                    );
                }

                // Buscar exame físico
                $sqlExameFisico = "SELECT * FROM exames_fisicos WHERE id_prontuario = :id_prontuario";
                $stmtExameFisico = $this->conn->prepare($sqlExameFisico);
                $stmtExameFisico->execute([':id_prontuario' => $idProntuario]);
                $dataExameFisico = $stmtExameFisico->fetch(PDO::FETCH_ASSOC);           
                $exameFisico = null;
                if ($dataExameFisico) {
                    $exameFisico = new ExameFisico(
                        $dataExameFisico['avaliacao_geral'],
                        $dataExameFisico['sinais_vitais'],
                        $dataExameFisico['exame_pele_anexos'],
                        $dataExameFisico['exame_cabeca_pescoco'],
                        $dataExameFisico['exame_cardiovascular'],
                        $dataExameFisico['exame_respiratorio'],
                        $dataExameFisico['exame_abdominal'],
                        $dataExameFisico['exame_neurologico'],
                        $dataExameFisico['exame_aparelho_locomotor'],
                        $idProntuario
                    );
                }

                // Buscar exames solicitados
                $sqlExames = "SELECT * FROM exames WHERE id_prontuario = :id_prontuario";
                $stmtExames = $this->conn->prepare($sqlExames);
                $stmtExames->execute([':id_prontuario' => $idProntuario]);
                $dataExames = $stmtExames->fetchAll(PDO::FETCH_ASSOC);     
                $listaExames = [];
                if ($dataExames) {
                    foreach ($dataExames as $ex) {
                        $exame = new Exame(
                            $ex['id_exame'],
                            $ex['nome'],
                            $idProntuario
                        );
                        $listaExames[] = $exame;
                    }         
                }

                // Buscar prescrição
                $sqlPrescricao = "SELECT * FROM prescricoes WHERE id_prontuario = :id_prontuario";
                $stmtPrescricao = $this->conn->prepare($sqlPrescricao);
                $stmtPrescricao->execute([':id_prontuario' => $idProntuario]);
                $dataPrescricao = $stmtPrescricao->fetch(PDO::FETCH_ASSOC);           
                $prescricao = null;
                if ($dataPrescricao) {
                    $prescricao = new Prescricao(
                        $dataPrescricao['id_prescricao'],
                        $medicamentos = [],
                        $dataPrescricao['recomendacoes'],
                        $idProntuario
                    );
                }
                $idPrescricao = $dataPrescricao['id_prescricao'];

                // Buscar medicamentos
                $sqlMedicamentos = "SELECT * FROM medicamentos WHERE id_prescricao = :id_prescricao";
                $stmtMedicamentos = $this->conn->prepare($sqlMedicamentos);
                $stmtMedicamentos->execute([':id_prescricao' => $idPrescricao]);
                $dataMedicamentos = $stmtMedicamentos->fetchAll(PDO::FETCH_ASSOC);           
                $listaMedicamentos = [];
                if ($dataMedicamentos) {
                    foreach ($dataMedicamentos as $med) {
                        $medicamento = new Medicamento(
                            $med['id_medicamento'],
                            $med['nome_medicamento'],
                            $med['concentracao'],
                            $med['forma_farmaceutica'],
                            $med['via_administracao'],
                            $med['tipo_receita'],
                            $med['intervalo_dose'],
                            $med['frequencia_dose'],
                            $med['turno_dose'],
                            $med['data_inicio'],
                            $med['quantidade_duracao'],
                            $med['tipo_duracao'],
                            $idPrescricao
                        );
                        $listaMedicamentos[] = $medicamento;
                    }
                }

                // Buscar internação
                $sqlInternacao = "SELECT * FROM internacoes WHERE id_prontuario = :id_prontuario";
                $stmtInternacao = $this->conn->prepare($sqlInternacao);
                $stmtInternacao->execute([':id_prontuario' => $idProntuario]);
                $dataInternacao = $stmtInternacao->fetch(PDO::FETCH_ASSOC);           
                $internacao = null;
                if ($dataInternacao) {
                    $internacao = new Internacao(
                        $dataInternacao['data_admissao_e_alta'],
                        $dataInternacao['diagnostico_internacao'],
                        $dataInternacao['procedimentos_cirurgicos'],
                        $dataInternacao['medicos_responsaveis'],
                        $idProntuario
                    );
                }

                // Buscar documentação
                $sqlDocumentacao = "SELECT * FROM documentacoes WHERE id_prontuario = :id_prontuario";
                $stmtDocumentacao = $this->conn->prepare($sqlDocumentacao);
                $stmtDocumentacao->execute([':id_prontuario' => $idProntuario]);
                $dataDocumentacao = $stmtDocumentacao->fetch(PDO::FETCH_ASSOC);           
                $documentacao = null;
                if ($dataDocumentacao) {
                    $documentacao = new Documentacao(
                        $dataDocumentacao['id_documentacao'],
                        $dataDocumentacao['termos_consentimento'],
                        null,
                        $dataDocumentacao['declaracao_saude'],
                        $idProntuario
                    );
                }
                $idDocumentacao = $dataDocumentacao['id_documentacao'];

                // Buscar atestado
                $idAtestado = null;
                $atestadoAcompanhante = null;
                $atestadoAfastamento = null;
                $atestadoComparecimento = null;
                $sqlAtestado = "SELECT * FROM atestados WHERE id_documentacao = :id_documentacao";
                $stmtAtestado = $this->conn->prepare($sqlAtestado);
                $stmtAtestado->execute([':id_documentacao' => $idDocumentacao]);
                $dataAtestado = $stmtAtestado->fetch(PDO::FETCH_ASSOC);           
                $atestado = null;
                if ($dataAtestado) {
                    $atestado = new Atestado(
                        $dataAtestado['id_atestado'],
                        $dataAtestado['cid10'],
                        $dataAtestado['texto_principal'],
                        $idDocumentacao
                    );
                    $idAtestado = $dataAtestado['id_atestado'];
                }      

                //Buscar atestado de acompanhante
                if ($idAtestado !== null) {
                    $sqlAtestadoAcompanhante = "SELECT * FROM atestados_acompanhante WHERE id_atestado = :id_atestado";
                    $stmtAtestadoAcompanhante = $this->conn->prepare($sqlAtestadoAcompanhante);
                    $stmtAtestadoAcompanhante->execute([':id_atestado' => $idAtestado]); 
                    $dataAtestadoAcompanhante = $stmtAtestadoAcompanhante->fetch(PDO::FETCH_ASSOC);           
                    $atestadoAcompanhante = null;
                    if ($dataAtestadoAcompanhante) {
                        $atestadoAcompanhante = new AtestadoAcompanhante(
                            $atestado->getIdAtestado(),
                            $atestado->getCid10(),
                            $atestado->getTextoPrincipal(),
                            $atestado->getIdDocumentacao(),
                            $dataAtestadoAcompanhante['nome_acompanhante'],
                            $dataAtestadoAcompanhante['cpf_acompanhante'],
                            $dataAtestadoAcompanhante['parentesco_acompanhante'],
                            $dataAtestadoAcompanhante['data'],
                            $dataAtestadoAcompanhante['horario_chegada'],
                            $dataAtestadoAcompanhante['horario_saida'],
                            
                        );
                    }
                }

                //Buscar atestado de afastamento
                if ($idAtestado !== null) {
                    $sqlAtestadoAfastamento = "SELECT * FROM atestados_afastamento WHERE id_atestado = :id_atestado";
                    $stmtAtestadoAfastamento = $this->conn->prepare($sqlAtestadoAfastamento);
                    $stmtAtestadoAfastamento->execute([':id_atestado' => $idAtestado]); 
                    $dataAtestadoAfastamento = $stmtAtestadoAfastamento->fetch(PDO::FETCH_ASSOC);           
                    $atestadoAfastamento = null;
                    if ($dataAtestadoAfastamento) {
                        $atestadoAfastamento = new AtestadoAfastamento(
                            $atestado->getIdAtestado(),
                            $atestado->getCid10(),
                            $atestado->getTextoPrincipal(),
                            $atestado->getIdDocumentacao(),
                            $dataAtestadoAfastamento['dias_afastamento'],
                            $dataAtestadoAfastamento['data_inicio'],
                            $dataAtestadoAfastamento['data_retorno'],
                            $idAtestado
                        );
                    }
                }

                //Buscar atestado de comparecimento
                if ($idAtestado !== null) {
                    $sqlAtestadoComparecimento = "SELECT * FROM atestados_comparecimento WHERE id_atestado = :id_atestado";
                    $stmtAtestadoComparecimento = $this->conn->prepare($sqlAtestadoComparecimento);
                    $stmtAtestadoComparecimento->execute([':id_atestado' => $idAtestado]); 
                    $dataAtestadoComparecimento = $stmtAtestadoComparecimento->fetch(PDO::FETCH_ASSOC);           
                    $atestadoComparecimento = null;
                    if ($dataAtestadoComparecimento) {
                        $atestadoComparecimento = new AtestadoComparecimento(
                            $atestado->getIdAtestado(),
                            $atestado->getCid10(),
                            $atestado->getTextoPrincipal(),
                            $atestado->getIdDocumentacao(),
                            $dataAtestadoComparecimento['data'],
                            $dataAtestadoComparecimento['horario_chegada'],
                            $dataAtestadoComparecimento['horario_saida'],
                            $idAtestado
                        );
                    }
                }
                
                $prontuario =  new Prontuario(
                    $row['id_prontuario'],
                    $row['data_criacao'],
                    $historicoMedico,
                    $anamnese,
                    $exameFisico,
                    $row['diagnostico_presuntivo'],
                    $row['diagnostico_diferencial'],
                    $row['diagnostico_definitivo'],
                    $row['cid10'],
                    $listaExames,
                    $prescricao,
                    $row['evolucao'],
                    $internacao,
                    $documentacao,
                    $row['doencas_notificacao_obrigatoria'],
                    $row['observacoes_adicionais'],
                    $row['id_paciente'],
                    $row['id_medico'],
                    $row['id_consulta'],
                    $nomeMedico
                );

                $prescricao->setMedicamentos($listaMedicamentos);

                if ($atestadoAcompanhante) {  
                    $documentacao->setAtestado($atestadoAcompanhante);
                } elseif ($atestadoAfastamento) { 
                    $documentacao->setAtestado($atestadoAfastamento);
                } elseif ($atestadoComparecimento) { 
                    $documentacao->setAtestado($atestadoComparecimento);
                }



                    $prontuarios[] = $prontuario;
                }

                return $prontuarios;    

            
        } catch (PDOException $e) {
            // Trate o erro apropriadamente
            echo "Erro ao buscar prontuários: " . $e->getMessage();
            return [];
        }
    }
}
