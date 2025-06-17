<?php

    require_once '../controller/PacienteController.php';
    require_once '../controller/ProntuarioController.php';

    //Armazena o id da consulta em uma variável
    $idConsulta = $_GET['id_consulta'];

    //Busca o prontuário
    $prontuarioController = new ProntuarioController();
    $prontuario = $prontuarioController->visualizarProntuario($idConsulta);

    //Conferir se existem exames solicitados
    $examesBanco = [];
    foreach ($prontuario->getExamesSolicitados() as $exame) {
        $examesBanco[] = $exame->getNomeExame();
    }

    //Conferir se existem medicamentos solicitados
    $medicamentosBanco = [];
    foreach ($prontuario->getPrescricao()->getMedicamentos() as $medicamento) {
        $medicamentosBanco[] = $medicamento;
    }

    //Busca o id do paciente
    $idPaciente = $prontuario->getIdPaciente();

    //Busca o paciente
    $pacienteController = new PacienteController();
    $paciente = $pacienteController->buscarPacienteCompleto($idPaciente);

?>

<!DOCTYPE html>
<html lang="pt-br">
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
        <a href="">sair</a>
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

                <!--Histórico Médico e Familiar-->
                <div class="menu-seta">
                    <h2>Histórico Médico e Familiar</h2>
                    <img id="seta" onclick="expandirRetrair('formulario2', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario2" class="formulario-oculto">
                    

                        <div class="nome-campo">
                            <label for="doencasPreExistentes">Doenças pré-existentes</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getHistoricoMedico()->getDoencasPreexistentes() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="medicacoesUsoContinuo">Medicaçõs de uso contínuo</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getHistoricoMedico()->getMedicacoesUsoContinuo() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="cirurgiasAnteriores">Cirurgias anteriores</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getHistoricoMedico()->getCirurgiasAnteriores() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="alergias">Alergias e reações adversas a medicamentos</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getHistoricoMedico()->getAlergiasMedicamentos() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="doencasFamilia">Histórico de doenças na família</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getHistoricoMedico()->getHistoricoDoencasFamilia() ?></div>
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
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getAnamnese()->getQueixaDuracao() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="doencaAtual">História da doença atual</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getAnamnese()->getHistoriaDoencaAtual() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="historiaSocial">História social</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getAnamnese()->getHistoriaSocial() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="ginecoObstetrica">História gineco-obstétrica (para mulheres)</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getAnamnese()->getHistoriaGinecoObstetrica() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="revisaoSistemas">Revisão de sistemas (sintomas em difentes sistemas do organismo) </label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getAnamnese()->getRevisaoSistemas() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="fatoresAgravantes">Fatores agravantes</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getAnamnese()->getFatoresAgravantes() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="atenuantes">Atenuantes</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getAnamnese()->getAtenuantes() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="tratamentosPrevios">Tratamentos Prévios</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getAnamnese()->getTratamentosPrevios() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="respostaTratamentosPrevios">Resposta aos tratamentos prévios</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getAnamnese()->getRespostaTratamentosPrevios() ?></div>
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
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getExameFisico()->getAvaliacaoGeral() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="sinaisVitais">Sinais vitais</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getExameFisico()->getSinaisVitais() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="examePele">Exame da pele e anexos (cabelos, unhas, mucosas)</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getExameFisico()->getExamePeleAnexos() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="exameCabeca">Exame da cabeça e pescoço</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getExameFisico()->getExameCabecaPescoco() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="exameCardio">Exame cardiovascular</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getExameFisico()->getExameCardiovascular() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="exameRespiratorio">Exame respiratório</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getExameFisico()->getExameRespiratorio() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="exameAbdominal">Exame abdominal</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getExameFisico()->getExameAbdominal() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="exameNeuro">Exame neurológico</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getExameFisico()->getExameNeurologico() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="exameLocomotor">Exame do aparelho locomotor</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getExameFisico()->getExameAparelhoLocomotor() ?></div>
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
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getDiagnosticoPresuntivo() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="diagDiferencial">Diagnóstico diferencial</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getDiagnosticoDiferencial() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="diagDefinitivo">Diagnóstico definitivo</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getDiagnosticoDefinitivo() ?></div>
                        </div>

                        <div class="nome-campo">
                            <label for="cid10">CID-10 (classificação internacional de doenças)</label>
                            <div class="input-estilizacao-padrao"><?php echo $prontuario->getCid10() ?>"</div>
                        </div>

                    
                </section>

                <!--Exames Solicitados-->
                <div class="menu-seta">
                    <h2>Exames Solicitados</h2>
                    <img id="seta" onclick="expandirRetrair('formulario6', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario6" class="formulario-oculto">
                    <ul id="lista-exames">
                        <?php foreach ($examesBanco as $exame): ?>
                            <div class="lista-exames">
                                <li><?php echo htmlspecialchars($exame) ?></li>
                            </div>
                        <?php endforeach; ?>
                    </ul>                   
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
                        <button id="botaoAtestado" type="button" onclick="window.location.href='detalhes-prescricao.php?id_consulta=<?php echo $idConsulta; ?>'">Visualizar prescrição</button>
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
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getEvolucao() ?></div>
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
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getInternacao()->getDataAdmissaoEAlta() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="diagInternacao">Diagnóstico de Internação</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getInternacao()->getDiagnosticoInternacao() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="cirurgiasInternacao">Procedimentos Cirúrgicos Realizados</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getInternacao()->getProcedimentosCirurgicos() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="medicosInternacao">Médicos Responsáveis</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getInternacao()->getMedicosResponsaveis() ?></div>
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
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getDocumentacao()->getTermosConsentimento() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="declaracoesSaude">Declarações de saúde</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getDocumentacao()->getDeclaracoesSaude() ?></div>
                    </div>

                    <ul id="atestados"></ul>
                    <div class="botao-solicitar-criar">
                        <button id="botaoAtestado" type="button" onclick="window.location.href='detalhes-atestado.php?id_consulta=<?php echo $idConsulta; ?>'">Visualizar atestado</button>
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
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getDoencasNotificacaoObrigatoria() ?></div>
                    </div>

                    <div class="nome-campo">
                        <label for="obsMedicas">Observações médicas adicionais</label>
                        <div class="input-estilizacao-padrao"><?php echo $prontuario->getObservacoesAdicionais() ?></div>
                    </div>

                </section>

                <div class="finalizar-consulta">
                    <button type="button" class="vermelho" id="voltarPagina">Voltar</button>
                </div>
                
            </section>
        </section>
    </main>

    <footer></footer>
    
    <script src="../../assets/script/detalhes-prontuario.js"></script>
    <script>
        //Função para voltar para histórico de consultas
        const voltarPagina = document.getElementById("voltarPagina");

        if (voltarPagina) {
            voltarPagina.addEventListener("click", () => {

                // Limpa o localStorage
                localStorage.removeItem('atestado');
                localStorage.removeItem('examesSolicitados');
                localStorage.removeItem('medicamentosPrescricao');
                localStorage.removeItem('recomendacoesPrescricao');
                
                window.location.href = `../../app/views/historico-consultas.php`;
            });
        }
    </script>
</body>
</html>