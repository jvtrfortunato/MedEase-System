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
    <?php

        require_once '../controller/PacienteController.php';
        require_once '../controller/ConsultaController.php';

        //Busca o paciente
        $pacienteController = new PacienteController();
        $paciente = $pacienteController->buscarPacienteCompleto($_SESSION['paciente_id']);
        $_SESSION['paciente_id'] = $paciente->getIdPaciente();
        $_SESSION['paciente_nome'] = $paciente->getNome();

        //Busca a consulta
        $consultaController = new ConsultaController();
        $consulta = $consultaController->buscarConsulta($_SESSION['consulta_id']);
        $_SESSION['consulta_motivo'] = $consulta->getMotivo();

    ?>

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
                <input type="hidden" name="acao" value="salvarProntuario">

                <!--Histórico Médico e Familiar-->
                <div class="menu-seta">
                    <h2>Histórico Médico e Familiar</h2>
                    <img id="seta" onclick="expandirRetrair('formulario2', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario2" class="formulario-oculto">
                    

                        <div class="nome-campo">
                            <label for="doencasPreExistentes">Doenças pré-existentes</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="doencasPreExistentes"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="medicacoesUsoContinuo">Medicaçõs de uso contínuo</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="medicacoesUsoContinuo"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="cirurgiasAnteriores">Cirurgias anteriores</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="cirurgiasAnteriores"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="alergias">Alergias e reações adversas a medicamentos</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="alergias"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="doencasFamilia">Histórico de doenças na família</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="doencasFamilia"></textarea>
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
                                <p><?= $consulta ? htmlspecialchars($consulta->getMotivo()) : '' ?></p> 
                            </div>

                        <div class="nome-campo">
                            <label for="queixa">Queixa e duração</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="queixa"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="doencaAtual">História da doença atual</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="doencaAtual"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="historiaSocial">História social</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="historiaSocial"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="ginecoObstetrica">História gineco-obstétrica (para mulheres)</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="ginecoObstetrica"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="revisaoSistemas">Revisão de sistemas (sintomas em difentes sistemas do organismo) </label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="revisaoSistemas"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="fatoresAgravantes">Fatores agravantes</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="fatoresAgravantes"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="atenuantes">Atenuantes</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="atenuantes"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="tratamentosPrevios">Tratamentos Prévios</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="tratamentosPrevios"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="respostaTratamentosPrevios">Resposta aos tratamentos prévios</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="respostaTratamentosPrevios"></textarea>
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
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="avaliacaoGeral"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="sinaisVitais">Sinais vitais</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="sinaisVitais"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="examePele">Exame da pele e anexos (cabelos, unhas, mucosas)</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="examePele"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameCabeca">Exame da cabeça e pescoço</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameCabeca"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameCardio">Exame cardiovascular</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameCardio"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameRespiratorio">Exame respiratório</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameRespiratorio"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameAbdominal">Exame abdominal</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameAbdominal"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameNeuro">Exame neurológico</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameNeuro"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="exameLocomotor">Exame do aparelho locomotor</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="exameLocomotor"></textarea>
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
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="diagPresuntivo"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="diagDiferencial">Diagnóstico diferencial</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="diagDiferencial"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="diagDefinitivo">Diagnóstico definitivo</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..." name="diagDefinitivo"></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="cid10">CID-10 (classificação internacional de doenças)</label>
                            <input type="text" name="cid10">
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
                    <!-- <input type="hidden" name="examesJSON" id="examesJSON"> -->
                    <div class="botao-solicitar-criar">
                        <button type='button' id="botao-exame" onclick="window.location.href='solicitar-exames.php'">Solicitar exames</button>
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
                        <button id="botaoPrescricao" type="button" onclick="window.location.href='criar-prescricao.php'">Criar prescrição</button>
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
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="evolucao"></textarea>
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
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="dataAdmissaoAlta"></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="diagInternacao">Diagnóstico de Internação</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="diagInternacao"></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="cirurgiasInternacao">Procedimentos Cirúrgicos Realizados</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="cirurgiasInternacao"></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="medicosInternacao">Médicos Responsáveis</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="medicosInternacao"></textarea>
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
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="termosConsentimento"></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="declaracoesSaude">Declarações de saúde</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="declaracoesSaude"></textarea>
                    </div>

                    <ul id="atestados"></ul>
                    <div class="botao-solicitar-criar">
                        <button id="botaoAtestado" type="button" onclick="window.location.href='criar-atestado.php'">Criar atestado</button>
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
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="notificacoesObrigatorias"></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="obsMedicas">Observações médicas adicionais</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..." name="obsMedicas"></textarea>
                    </div>

                </section>

                <input type="hidden" name="atestadoJSON" id="atestadoJSON">
                <input type="hidden" name="examesJSON" id="examesJSON">
                <input type="hidden" name="medicamentosJSON" id="medicamentosJSON">
                <input type="hidden" name="recomendacoesJSON" id="recomendacoesJSON">

                <div class="finalizar-consulta">
                    <button type="button" class="vermelho" id="voltarPagina">Voltar</button>
                    <button type='submit' class="verde">Finalizar Consulta</button>
                </div>
                
            </form>

            </section>
        </section>
    </main>

    <footer></footer>
    
    <script src="../../assets/script/prontuario.js"></script>
</body>
</html>
