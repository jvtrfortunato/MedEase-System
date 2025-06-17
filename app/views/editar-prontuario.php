<?php

    require_once '../controller/ProntuarioController.php';
    require_once '../controller/PacienteController.php';
    require_once '../controller/ConsultaController.php';

    //Busca o prontuário
    $prontuarioController = new ProntuarioController();
    $prontuario = $prontuarioController->visualizarProntuario($_GET['consulta_id']);

    //Conferir se existem exames solicitados
    $examesBanco = [];
    foreach ($prontuario->getExamesSolicitados() as $exame) {
        $examesBanco[] = $exame;
    }

    // Transformar os exames em arrays associativos
    $examesFormatados = array_map(function($exame) {
        return [
            'idExame' => $exame->getIdExame(),
            'nomeExame' => $exame->getNomeExame(),
            'idProntuario' => $exame->getIdProntuario()
        ];
    }, $examesBanco);

    //Conferir se existem medicamentos solicitados
    $medicamentosBanco = [];
    foreach ($prontuario->getPrescricao()->getMedicamentos() as $medicamento) {
        $medicamentosBanco[] = $medicamento;
    }

    $recomendacoesBanco = $prontuario->getPrescricao()->getRecomendacoes();
    $idPrescricao = $prontuario->getPrescricao()->getIdPrescricao();
    $idProntuario = $prontuario->getIdProntuario();
    $idDocumentacao = $prontuario->getDocumentacao()->getIdDocumentacao();
    $idAtestado = $prontuario->getDocumentacao()->getAtestado()->getIdAtestado();

    // Transforma os medicamentos em arrays associativos
    $medicamentosFormatados = array_map(function($med) {
        return [
            'id_medicamento' => $med->getIdMedicamento(),
            'nome_medicamento' => $med->getNomeMedicamento(),
            'concentracao' => $med->getConcentracao(),
            'forma_farmaceutica' => $med->getFormaFarmaceutica(),
            'via_administracao' => $med->getViaAdministracao(),
            'tipo_receita' => $med->getTipoReceita(),
            'intervalo_dose' => $med->getIntervaloDose(),
            'frequencia_dose' => $med->getFrequenciaDose(),
            'turno_dose' => $med->getTurnoDose(),
            'data_inicio' => $med->getDataInicio(),
            'quantidade_duracao' => $med->getQuantidadeDuracao(),
            'tipo_duracao' => $med->getTipoDuracao(),
            'id_prescricao' => $med->getIdPrescricao()
        ];
    }, $medicamentosBanco);

    //Conferir se existe atestado criado
    $atestadoBanco = $prontuario->getDocumentacao()->getAtestado();

    //Tranforma o objeto atestado em array associativo
    $atestadoFormatado = [];

    if ($atestadoBanco instanceof AtestadoAfastamento) {
        $atestadoFormatado = [
            'tipo' => 'afastamento',
            'idAtestado' => $atestadoBanco->getIdAtestado(),
            'cid10' => $atestadoBanco->getCid10(),
            'textoPrincipal' => $atestadoBanco->getTextoPrincipal(),
            'idDocumentacao' => $atestadoBanco->getIdDocumentacao(),
            'diasAfastamento' => $atestadoBanco->getDiasAfastamento(),
            'dataInicio' => $atestadoBanco->getDataInicio(),
            'dataRetorno' => $atestadoBanco->getDataRetorno()
        ];
    } elseif ($atestadoBanco instanceof AtestadoAcompanhante) {
        $atestadoFormatado = [
            'tipo' => 'acompanhante',
            'id_atestado' => $atestadoBanco->getIdAtestado(),
            'cid10' => $atestadoBanco->getCid10(),
            'textoPrincipal' => $atestadoBanco->getTextoPrincipal(),
            'idDocumentacao' => $atestadoBanco->getIdDocumentacao(),
            'nomeAcompanhante' => $atestadoBanco->getNomeAcompanhante(),
            'cpfAcompanhante' => $atestadoBanco->getCpfAcompanhante(),
            'parentescoAcompanhante' => $atestadoBanco->getParentescoAcompanhante(),
            'data' => $atestadoBanco->getData(),
            'horarioChegada' => $atestadoBanco->getHorarioChegada(),
            'horarioSaida' => $atestadoBanco->getHorarioSaida()
        ];
    } elseif ($atestadoBanco instanceof AtestadoComparecimento) {
        $atestadoFormatado = [
            'tipo' => 'comparecimento',
            'id_atestado' => $atestadoBanco->getIdAtestado(),
            'cid10' => $atestadoBanco->getCid10(),
            'textoPrincipal' => $atestadoBanco->getTextoPrincipal(),
            'idDocumentacao' => $atestadoBanco->getIdDocumentacao(),
            'data' => $atestadoBanco->getData(),
            'horarioChegada' => $atestadoBanco->getHorarioChegada(),
            'horarioSaida' => $atestadoBanco->getHorarioSaida()
        ];
    }

    //Busca o id do paciente
    $idPaciente = $prontuario->getIdPaciente();

    //Busca o paciente
    $pacienteController = new PacienteController();
    $paciente = $pacienteController->buscarPacienteCompleto($idPaciente);


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontuário do Paciente</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/prontuario.css">
</head>
<body>

    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>

    <main>
        <section class="conteudo-principal">
            <h1>Prontuário Eletrônico do Paciente</h1>
            <section class="dados-prontuario">
            
            
            <!--Identificação do Paciente-->
            <div class="menu-seta">
                <h2>Identificação do Paciente</h2>
                <img id="seta" onclick="expandirRetrair('formulario1', this)" src="../../assets/img/seta-baixo.png" alt="seta">
            </div>
            <div class="barra"></div>                
            <section id="formulario1" class="formulario-visivel">
                    
                    <div class="linha-dados">
                        <div class="input-grande">
                            <p class="label">Nome completo</p>
                            <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getNome()) : '' ?></div>
                        </div>
                        <div class="div-medios">
                            <div class="input-medio">
                                <p class="label">Data de Nascimento</p>
                                <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars(date("d/m/Y", strtotime($paciente->getDataNascimento()))) : '' ?></div>
                            </div>
                            <div class="input-medio">
                                <p class="label">Sexo</p>
                                <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getSexo()) : '' ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="linha-dados">
                        <div class="input-grande">
                            <p class="label">Estado Civil</p>
                            <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getEstadoCivil()) : '' ?></div>
                        </div>
                        <div class="div-medios">
                            <div class="input-medio">
                                <p class="label">CPF</p>
                                <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getCpf()) : '' ?></div>
                            </div>
                            <div class="input-medio">
                                <p class="label">RG</p>
                                <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getRg()) : '' ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="linha-dados">
                        <div class="input-grande">
                            <p class="label">Rua</p>
                            <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getEndereco()->getRua()) : '' ?></div>
                        </div>
                        <div class="div-medios">
                            <div class="input-medio">
                                <p class="label">Número</p>
                                <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getEndereco()->getNumero()) : '' ?></div>
                            </div>
                            <div class="input-medio">
                                <p class="label">Bairro</p>
                                <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getEndereco()->getBairro()) : '' ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="linha-dados">
                        <div class="input-grande">
                            <p class="label">Cidade</p>
                            <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getEndereco()->getCidade()) : '' ?></div>
                        </div>
                        <div class="div-medios">
                            <div class="input-medio">
                                <p class="label">Estado</p>
                                <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getEndereco()->getEstado()) : '' ?></div>
                            </div>
                            <div class="input-medio">
                                <p class="label">CEP</p>
                                <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getEndereco()->getCep()) : '' ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="linha-dados">
                        <div class="input-grande">
                            <p class="label">Telefone</p>
                            <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getTelefone()) : '' ?></div>
                        </div>
                        <div class="input-grande">
                            <p class="label">Email</p>
                            <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getEmail()) : '' ?></div>
                        </div>
                    </div>

                    <div class="linha-dados">
                        <div class="input-grande">
                            <p class="label">Nome do responsável</p>
                            <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getNomeResponsavel()) : '' ?></div>
                        </div>
                        <div class="input-grande">
                            <p class="label">CNS</p>
                            <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getCns()) : '' ?></div>
                        </div>
                    </div>

                    <div class="linha-dados">
                        <div class="input-grande">
                            <p class="label">Convênio</p>
                            <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getConvenio()) : '' ?></div>
                        </div>
                        <div class="input-grande">
                            <p class="label">Nº do Plano de Saúde</p>
                            <div class="input-estilizacao-padrao"> <?= $paciente ? htmlspecialchars($paciente->getPlanoSaude()) : '' ?></div>
                        </div>
                    </div>

                
            </section>

            <form id="salvarProntuario" action="../routers/roteadorProntuario.php" method="post">
                <input type="hidden" name="acao" value="atualizarProntuario">

                <!--Histórico Médico e Familiar-->
                <div class="menu-seta">
                    <h2>Histórico Médico e Familiar</h2>
                    <img id="seta" onclick="expandirRetrair('formulario2', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario2" class="formulario-oculto">
                    

                        <div class="nome-campo">
                            <label for="doencasPreExistentes">Doenças pré-existentes</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="doencasPreExistentes"><?php echo $prontuario->getHistoricoMedico()->getDoencasPreexistentes() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="medicacoesUsoContinuo">Medicaçõs de uso contínuo</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="medicacoesUsoContinuo"><?php echo $prontuario->getHistoricoMedico()->getMedicacoesUsoContinuo() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="cirurgiasAnteriores">Cirurgias anteriores</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="cirurgiasAnteriores"><?php echo $prontuario->getHistoricoMedico()->getCirurgiasAnteriores() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="alergias">Alergias e reações adversas a medicamentos</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="alergias"><?php echo $prontuario->getHistoricoMedico()->getAlergiasMedicamentos() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="doencasFamilia">Histórico de doenças na família</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="doencasFamilia"><?php echo $prontuario->getHistoricoMedico()->getHistoricoDoencasFamilia() ?></textarea>
                        </div>   

                    
                </section>

                <!--Anamnese-->
                <div class="menu-seta">
                    <h2>Anamnese</h2>
                    <img id="seta" onclick="expandirRetrair('formulario3', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario3" class="formulario-oculto">
                    

                            <h3>Motivo da consulta</h3>
                            <div class="motivo-consulta">
                                <p><?php echo $prontuario->getAnamnese()->getMotivoConsulta() ?></p> 
                            </div>

                        <div class="nome-campo">
                            <label for="queixa">Queixa e duração</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="queixa"><?php echo $prontuario->getAnamnese()->getQueixaDuracao() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="doencaAtual">História da doença atual</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="doencaAtual"><?php echo $prontuario->getAnamnese()->getHistoriaDoencaAtual() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="historiaSocial">História social</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="historiaSocial"><?php echo $prontuario->getAnamnese()->getHistoriaSocial() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="ginecoObstetrica">História gineco-obstétrica (para mulheres)</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="ginecoObstetrica"><?php echo $prontuario->getAnamnese()->getHistoriaGinecoObstetrica() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="revisaoSistemas">Revisão de sistemas (sintomas em difentes sistemas do organismo) </label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="revisaoSistemas"><?php echo $prontuario->getAnamnese()->getRevisaoSistemas() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="fatoresAgravantes">Fatores agravantes</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="fatoresAgravantes"><?php echo $prontuario->getAnamnese()->getFatoresAgravantes() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="atenuantes">Atenuantes</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="atenuantes"><?php echo $prontuario->getAnamnese()->getAtenuantes() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="tratamentosPrevios">Tratamentos Prévios</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="tratamentosPrevios"><?php echo $prontuario->getAnamnese()->getTratamentosPrevios() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="respostaTratamentosPrevios">Resposta aos tratamentos prévios</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="respostaTratamentosPrevios"><?php echo $prontuario->getAnamnese()->getRespostaTratamentosPrevios() ?></textarea>
                        </div>

                    
                </section>

                <!--Exame Físico-->
                <div class="menu-seta">
                    <h2>Exame Físico</h2>
                    <img id="seta" onclick="expandirRetrair('formulario4', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario4" class="formulario-oculto">
                    

                        <div class="nome-campo">
                            <label for="avaliacaoGeral">Avaliação geral</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="avaliacaoGeral"><?php echo $prontuario->getExameFisico()->getAvaliacaoGeral() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="sinaisVitais">Sinais vitais</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="sinaisVitais"><?php echo $prontuario->getExameFisico()->getSinaisVitais() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="examePele">Exame da pele e anexos (cabelos, unhas, mucosas)</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="examePele"><?php echo $prontuario->getExameFisico()->getExamePeleAnexos() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameCabeca">Exame da cabeça e pescoço</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameCabeca"><?php echo $prontuario->getExameFisico()->getExameCabecaPescoco() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameCardio">Exame cardiovascular</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameCardio"><?php echo $prontuario->getExameFisico()->getExameCardiovascular() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameRespiratorio">Exame respiratório</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameRespiratorio"><?php echo $prontuario->getExameFisico()->getExameRespiratorio() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameAbdominal">Exame abdominal</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameAbdominal"><?php echo $prontuario->getExameFisico()->getExameAbdominal() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameNeuro">Exame neurológico</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameNeuro"><?php echo $prontuario->getExameFisico()->getExameNeurologico() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameLocomotor">Exame do aparelho locomotor</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameLocomotor"><?php echo $prontuario->getExameFisico()->getExameAparelhoLocomotor() ?></textarea>
                        </div>

                    
                </section>

                <!--Diagnóstico-->
                <div class="menu-seta">
                    <h2>Diagnóstico</h2>
                    <img id="seta" onclick="expandirRetrair('formulario5', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario5" class="formulario-oculto">
                    

                        <div class="nome-campo">
                            <label for="diagPresuntivo">Diagnóstico presuntivo</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="diagPresuntivo"><?php echo $prontuario->getDiagnosticoPresuntivo() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="diagDiferencial">Diagnóstico diferencial</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="diagDiferencial"><?php echo $prontuario->getDiagnosticoDiferencial() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="diagDefinitivo">Diagnóstico definitivo</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="diagDefinitivo"><?php echo $prontuario->getDiagnosticoDefinitivo() ?></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="cid10">CID-10 (classificação internacional de doenças)</label>
                            <input type="text" name="cid10" value="<?php echo $prontuario->getCid10() ?>">
                        </div>

                    
                </section>

                <!--Exames Solicitados-->
                <div class="menu-seta">
                    <h2>Exames Solicitados</h2>
                    <img id="seta" onclick="expandirRetrair('formulario6', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario6" class="formulario-oculto">
                    <ul id="lista-exames"></ul>
                    <div class="botao-solicitar-criar">
                        <?php if (!empty($examesBanco)) : ?>
                            <button type='button' id="botao-exame" onclick="window.location.href='editar-exames-solicitados.php?consulta_id=<?php echo $prontuario->getIdConsulta(); ?>&prontuario_id=<?php echo $idProntuario ?>'">Editar exames</button>
                        <?php else : ?>
                            <button type='button' id="botao-exame" onclick="window.location.href='editar-exames-solicitados.php?consulta_id=<?php echo $prontuario->getIdConsulta(); ?>&prontuario_id=<?php echo $idProntuario ?>'">Solicitar exames</button>
                        <?php endif; ?>
                    </div>                   
                </section>

                <!--Prescrições Médicas-->
                <div class="menu-seta">
                    <h2>Prescrição Médica</h2>
                    <img id="seta" onclick="expandirRetrair('formulario7', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario7" class="formulario-oculto">
                    <ul id="medicamentosPrescricao"></ul>
                    <div class="botao-solicitar-criar">
                        <?php if (!empty($medicamentosBanco)) : ?>
                            <button type='button' id="botaoPrescricao" onclick="window.location.href='editar-prescricao.php?consulta_id=<?php echo $prontuario->getIdConsulta(); ?>&prescricao_id=<?php echo $idPrescricao ?>'">Editar prescrição</button>
                        <?php else : ?>
                            <button type='button' id="botaoPrescricao" onclick="window.location.href='editar-prescricao.php?consulta_id=<?php echo $prontuario->getIdConsulta(); ?>&prescricao_id=<?php echo $idPrescricao ?>'">Criar prescrição</button>
                        <?php endif; ?>
                    </div>                   
                </section>

                <!--Evolução do Quadro Clínico-->
                <div class="menu-seta">
                    <h2>Evolução do Quadro Clínico (observações de consultas sucessivas)</h2>
                    <img id="seta" onclick="expandirRetrair('formulario8', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario8" class="formulario-oculto">
                    <div class="nome-campo">
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="evolucao"><?php echo $prontuario->getEvolucao() ?></textarea>
                    </div>                   
                </section>

                <!--Registro de Internação e Cirurgias-->
                <div class="menu-seta">
                    <h2>Registros de Internação e Cirurgias</h2>
                    <img id="seta" onclick="expandirRetrair('formulario10', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario10" class="formulario-oculto">
                                      
                    <div class="nome-campo">
                        <label for="dataAdmissaoAlta">Data de Admissão e Alta Hospitalar</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="dataAdmissaoAlta"><?php echo $prontuario->getInternacao()->getDataAdmissaoEAlta() ?></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="diagInternacao">Diagnóstico de Internação</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="diagInternacao"><?php echo $prontuario->getInternacao()->getDiagnosticoInternacao() ?></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="cirurgiasInternacao">Procedimentos Cirúrgicos Realizados</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="cirurgiasInternacao"><?php echo $prontuario->getInternacao()->getProcedimentosCirurgicos() ?></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="medicosInternacao">Médicos Responsáveis</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="medicosInternacao"><?php echo $prontuario->getInternacao()->getMedicosResponsaveis() ?></textarea>
                    </div>

                </section>

                <!--Documentação e Consentimentos-->
                <div class="menu-seta">
                    <h2>Documentação e Atestado</h2>
                    <img id="seta" onclick="expandirRetrair('formulario11', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario11" class="formulario-oculto">
                                      
                    <div class="nome-campo">
                        <label for="termosConsentimento">Termos de consentimento informado para procedimentos</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="termosConsentimento"><?php echo $prontuario->getDocumentacao()->getTermosConsentimento() ?></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="declaracoesSaude">Declarações de saúde</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="declaracoesSaude"><?php echo $prontuario->getDocumentacao()->getDeclaracoesSaude() ?></textarea>
                    </div>

                    <ul id="atestados"></ul>
                    <div class="botao-solicitar-criar">
                        <button id="botaoAtestado" type="button" onclick="window.location.href='editar-atestado.php?consulta_id=<?php echo $prontuario->getIdConsulta(); ?>&documentacao_id=<?php echo $idDocumentacao ?>&atestado_id=<?php echo $idAtestado ?>'">Criar atestado</button>
                    </div>

                </section>

                <!--Observações Gerais e Notificações-->
                <div class="menu-seta">
                    <h2>Observações Gerais e Notificações</h2>
                    <img id="seta" onclick="expandirRetrair('formulario13', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario13" class="formulario-oculto">
                                      
                    <div class="nome-campo">
                        <label for="notificacoesObrigatorias">Doenças de notificação obrigatória (ex: COVID-19, tuberculose)</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="notificacoesObrigatorias"><?php echo $prontuario->getDoencasNotificacaoObrigatoria() ?></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="obsMedicas">Observações médicas adicionais</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="obsMedicas"><?php echo $prontuario->getObservacoesAdicionais() ?></textarea>
                    </div>

                </section>

                <input type="hidden" name="atestadoJSON" id="atestadoJSON">
                <input type="hidden" name="examesJSON" id="examesJSON">
                <input type="hidden" name="medicamentosJSON" id="medicamentosJSON">
                <input type="hidden" name="recomendacoesJSON" id="recomendacoesJSON">
                
                <input type="hidden" name="id_prontuario" value="<?php echo $prontuario->getIdProntuario() ?>">
                <input type="hidden" name="id_prescricao" value="<?php echo $prontuario->getPrescricao()->getIdPrescricao() ?>">
                <input type="hidden" name="id_documentacao" value="<?php echo $prontuario->getDocumentacao()->getIdDocumentacao() ?>">

                <div class="finalizar-consulta">
                    <button type="button" class="vermelho" id="voltarPagina">Voltar</button>
                    <button type='submit' class="verde">Confirmar alterações</button>
                </div>
                
            </form>

            </section>
        </section>
    </main>

    <footer></footer>
    
    <script>

    document.addEventListener('DOMContentLoaded', function () {
        // Só envia os dados do banco se não houver exames no localStorage
        const examesLocalStorage = JSON.parse(localStorage.getItem('examesSolicitados'));

        if (!examesLocalStorage) {
            const examesDoBanco = <?= json_encode($examesFormatados) ?>;
            console.log("Exames carregados do banco:", examesDoBanco);
            localStorage.setItem('examesSolicitados', JSON.stringify(examesDoBanco));
        } else {
            console.log("Exames carregados do localStorage:", examesLocalStorage);
        }

        // Só envia os dados do banco se não houver medicamentos no localStorage
        if (!localStorage.getItem('medicamentosPrescricao')) {
            const medicamentosDoBanco = <?= json_encode($medicamentosFormatados, JSON_UNESCAPED_UNICODE) ?>;
            const recomendacoesDoBanco = <?= json_encode($recomendacoesBanco, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

            console.log("Medicamentos carregados do banco:", medicamentosDoBanco);
            console.log("Recomendações carregadas do banco:", recomendacoesDoBanco);

            localStorage.setItem('medicamentosPrescricao', JSON.stringify(medicamentosDoBanco));
            localStorage.setItem('recomendacoesPrescricao', recomendacoesDoBanco);
        } else {
            const medicamentos = JSON.parse(localStorage.getItem('medicamentosPrescricao')) || [];
            const recomendacoes = localStorage.getItem('recomendacoesPrescricao') || '';

            console.log("Medicamentos carregados do js:", medicamentos);
            console.log("Recomendações carregadas do js:", recomendacoes);
        }

        // Só envia os dados do banco se não houver atestado no localStorage
        const atestadoStr = localStorage.getItem('atestado');
        if (!atestadoStr) {
            const atestadoDoBanco = <?= json_encode($atestadoFormatado, JSON_UNESCAPED_UNICODE) ?>;
            console.log("Atestado carregado do banco:", atestadoDoBanco);
            localStorage.setItem('atestado', JSON.stringify(atestadoDoBanco));
        } else {
            const atestadoLocalStorage = JSON.parse(atestadoStr);
            console.log("Atestado carregado do localStorage:", atestadoLocalStorage);
        }
    });
    </script>
    
    <script src="../../assets/script/editar-prontuario.js"></script>
    
</body>
</html>
