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
    require_once '../model/Prontuario.php';
    require_once '../model/Paciente.php';
    require_once '../model/Endereco.php';
    require_once '../model/HistoricoMedico.php';
    require_once '../model/Anamnese.php';
    require_once '../model/ExameFisico.php';
    require_once '../model/Prescricao.php';
    require_once '../model/Internacao.php';
    require_once '../model/Documentacao.php';
    require_once '../model/Atestado.php';

    session_start();

    $prontuario = isset($_SESSION['prontuario']) ? unserialize($_SESSION['prontuario']) : null;

    $paciente = $prontuario ? $prontuario->getPaciente() : null;
    $endereco = $paciente ? $paciente->getEndereco() : null;

    // Recuperar o motivo da consulta a partir da anamnese
    $motivoConsulta = null;

    if ($prontuario && $prontuario->getAnamnese()) {
        $motivoConsulta = $prontuario->getAnamnese()->getMotivoConsulta();
    }
    ?>

    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>

    <main>
        <section class="conteudo-principal">
            <h1>Prontuário Eletrônico do Paciente</h1>
            <section class="dados-prontuario">
            
            <form action="../controller/ProntuarioController.php" method="post">
                <input type="hidden" name="acao" value="salvar">
                <input type="hidden" name="examesSolicitados" id="examesSolicitadosInput">
                <!--Identificação do Paciente-->
                <div class="menu-seta">
                    <h2>Identificação do Paciente</h2>
                    <img id="seta" onclick="expandirRetrair('formulario1', this)" src="../../assets/img/seta-baixo.png" alt="seta">
                </div>
                <div class="barra"></div>                
                <section id="formulario1" class="formulario-visivel">
                        
                        <div class="linha-dados">
                            <div class="input-grande">
                                <label for="">Nome completo</label>
                                <input class="input-estilizacao-padrao" type="text"
                                name="nome"
                                value="<?= $paciente ? htmlspecialchars($paciente->getNome()) : '' ?>">
                            </div>
                            <div class="div-medios">
                                <div class="input-medio">
                                    <label for="">Data de Nascimento</label>
                                    <input class="input-estilizacao-padrao" type="date"
                                    name="dataNascimento"
                                    value="<?= $paciente ? $paciente->getDataNascimento() : '' ?>">
                                </div>
                                <div class="input-medio">
                                    <label for="">Sexo</label>
                                    <input class="input-estilizacao-padrao" type="text"
                                    name="sexo"
                                    value="<?= $paciente ? htmlspecialchars($paciente->getSexo()) : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="linha-dados">
                            <div class="input-grande">
                                <label for="">Estado Civil</label>
                                <input class="input-estilizacao-padrao" type="text"
                                name="estadoCivil"
                                value="<?= $paciente ? htmlspecialchars($paciente->getEstadoCivil()) : '' ?>">
                            </div>
                            <div class="div-medios">
                                <div class="input-medio">
                                    <label for="">CPF</label>
                                    <input class="input-estilizacao-padrao" type="text"
                                    name="cpf"
                                    value="<?= $paciente ? htmlspecialchars($paciente->getCpf()) : '' ?>">
                                </div>
                                <div class="input-medio">
                                    <label for="">RG</label>
                                    <input class="input-estilizacao-padrao" type="text"
                                    name="rg"
                                    value="<?= $paciente ? htmlspecialchars($paciente->getRg()) : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="linha-dados">
                            <div class="input-grande">
                                <label for="">Rua</label>
                                <input class="input-estilizacao-padrao" type="text"
                                name="rua"
                                value="<?= $endereco ? htmlspecialchars($endereco->getRua()) : '' ?>">
                            </div>
                            <div class="div-medios">
                                <div class="input-medio">
                                    <label for="">Número</label>
                                    <input class="input-estilizacao-padrao" type="number"
                                    name="numero"
                                    value="<?= $endereco ? htmlspecialchars($endereco->getNumero()) : '' ?>">
                                </div>
                                <div class="input-medio">
                                    <label for="">Bairro</label>
                                    <input class="input-estilizacao-padrao" type="text"
                                    name="bairro"
                                    value="<?= $endereco ? htmlspecialchars($endereco->getBairro()) : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="linha-dados">
                            <div class="input-grande">
                                <label for="">Cidade</label>
                                <input class="input-estilizacao-padrao" type="text"
                                name="cidade"
                                value="<?= $endereco ? htmlspecialchars($endereco->getCidade()) : '' ?>">
                            </div>
                            <div class="div-medios">
                                <div class="input-medio">
                                    <label for="">Estado</label>
                                    <input class="input-estilizacao-padrao" type="text"
                                    name="estado"
                                    value="<?= $endereco ? htmlspecialchars($endereco->getEstado()) : '' ?>">
                                </div>
                                <div class="input-medio">
                                    <label for="">CEP</label>
                                    <input class="input-estilizacao-padrao" type="text"
                                    name="cep"
                                    value="<?= $endereco ? htmlspecialchars($endereco->getCep()) : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="linha-dados">
                            <div class="input-grande">
                                <label for="">Telefone</label>
                                <input class="input-estilizacao-padrao" type="text"
                                name="telefone"
                                value="<?= $paciente ? htmlspecialchars($paciente->getTelefone()) : '' ?>">
                            </div>
                            <div class="input-grande">
                                <label for="">Email</label>
                                <input class="input-estilizacao-padrao" type="text"
                                name="email"
                                value="<?= $paciente ? htmlspecialchars($paciente->getEmail()) : '' ?>">
                            </div>
                        </div>

                        <div class="linha-dados">
                            <div class="input-grande">
                                <label for="">Nome do responsável</label>
                                <input class="input-estilizacao-padrao" type="text"
                                name="nomeResponsavel"
                                value="<?= $paciente ? htmlspecialchars($paciente->getNomeResponsavel()) : '' ?>">
                            </div>
                            <div class="input-grande">
                                <label for="">Cartão Nacional de Saúde (CNS)</label>
                                <input class="input-estilizacao-padrao" type="text"
                                name="cns"
                                value="<?= $paciente ? htmlspecialchars($paciente->getCns()) : '' ?>">
                            </div>
                        </div>

                        <div class="linha-dados">
                            <div class="input-grande">
                                <label for="">Convênio</label>
                                <input class="input-estilizacao-padrao" type="text"
                                name="convenio"
                                value="<?= $paciente ? htmlspecialchars($paciente->getConvenio()) : '' ?>">
                            </div>
                            <div class="input-grande">
                                <label for="">Número do Plano de Saúde</label>
                                <input class="input-estilizacao-padrao" type="text"
                                name="planoSaude"
                                value="<?= $paciente ? htmlspecialchars($paciente->getPlanoSaude()) : '' ?>">
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
                            <label for="">Doenças pré-existentes</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Medicaçõs de uso contínuo</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Cirurgias anteriores</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Alergias e reações adversas a medicamentos</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Histórico de doenças na família</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
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
                                <p><?php echo htmlspecialchars($motivoConsulta); ?></p> 
                            </div>

                        <div class="nome-campo">
                            <label for="">Queixa e duração</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">História da doença atual</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">História social</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">História gineco-obstétrica (para mulheres)</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Revisão de sistemas (sintomas em difentes sistemas do organismo) </label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
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
                            <label for="">Avaliação geral</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Sinais vitais</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Exame da pele e anexos (cabelos, unhas, mucosas)</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Exame da cabeça e pescoço</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Exame cardiovascular</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Exame respiratório</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Exame abdominal</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Exame neurológico</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Exame do aparelho locomotor</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
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
                            <label for="">Diagnóstico presuntivo</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Diagnóstico diferencial</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">Diagnóstico definitivo</label>
                            <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                        </div>

                        <div class="nome-campo">
                            <label for="">CID-10 (classificação internacional de doenças)</label>
                            <select name="" id="">
                                <option value="">Selecione</option>
                                <option value="">A00 - Cólera</option>
                                <option value="">J45 - Asma</option>
                                <option value="">F32.1 - Episódio depressivo moderado</option>
                            </select>
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
                        <button type='button' id="botao-exame" onclick="window.location.href='solicitar-exames.php'">Solicitar exame</button>
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
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>                   
                </section>

                <!--Exames de Imagem e Procedimentos-->
                <div class="menu-seta">
                    <h2>Exames de Imagem e Procedimentos</h2>
                    <img id="seta" onclick="expandirRetrair('formulario9', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario9" class="formulario-oculto">
                                      
                    <div class="nome-campo">
                        <label for="">Laudos de Exames de Imagem</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="">Procedimentos Realizados (cirurgias, curativos, vacinação, etc.)</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
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
                        <label for="">Data de Admissão e Alta Hospitalar</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="">Diagnóstico de Internação</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="">Procedimentos Cirúrgicos Realizados</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="">Médicos Responsáveis</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>

                </section>

                <!--Documentação e Consentimentos-->
                <div class="menu-seta">
                    <h2>Documentação e Consentimentos</h2>
                    <img id="seta" onclick="expandirRetrair('formulario11', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario11" class="formulario-oculto">
                                      
                    <div class="nome-campo">
                        <label for="">Termos de consentimento informado para procedimentos</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="">Atestados Médicos</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="">Declarações de saúde e formulários legais</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>

                </section>

                <!--Agendamentos e Histórico de Consultas-->
                <div class="menu-seta">
                    <h2>Agendamentos e Histórico de Consultas</h2>
                    <img id="seta" onclick="expandirRetrair('formulario12', this)" src="../../assets/img/seta-direita.png" alt="seta">
                </div>
                <div class="barra"></div>
                <section id="formulario12" class="formulario-oculto">
                                      
                    <div class="nome-campo">
                        <label for="">Consultas passadas</label>
                        <!--IMPLEMENTAR A LISTA DE PRONTUÁRIOS PERTENCENTENS A CONSULTAS PASSADAS AQUI-->
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
                        <label for="">Doenças de notificação obrigatória (ex: COVID-19, tuberculose)</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>

                    <div class="nome-campo">
                        <label for="">Observações médicas adicionais</label>
                        <textarea rows="8" cols="50" placeholder="Digite aqui..."></textarea>
                    </div>

                </section>

                <div class="finalizar-consulta">
                    <button type='submit'>Finalizar Consulta</button>
                </div>
            </form>

            </section>
        </section>
    </main>

    <footer></footer>
    
    <script>

        //Função para expandir ou retrair os campos do prontuário
        function expandirRetrair(idFormulario, setaImg) {
            const formulario = document.getElementById(idFormulario);
            const visivel = formulario.classList.contains('formulario-visivel');

            if (visivel) {
                formulario.classList.remove('formulario-visivel');
                formulario.classList.add('formulario-oculto');
                setaImg.src = '../../assets/img/seta-direita.png';
            }   else {
                formulario.classList.remove('formulario-oculto');
                formulario.classList.add('formulario-visivel');
                setaImg.src = '../../assets/img/seta-baixo.png';
            }
        }

        //Função que exibe os exames solicitados ao voltar para o prontuário
        window.onload = function() {
            const exames = JSON.parse(localStorage.getItem('examesSolicitados')) || [];
            const lista = document.getElementById('lista-exames');
            const botao = document.getElementById('botao-exame');
            
            lista.innerHTML = '';
            exames.forEach(exame => {
                const container = document.createElement('div');
                container.classList.add('lista-exames');

                const li = document.createElement('li');
                li.textContent = exame;

                container.appendChild(li);
                lista.appendChild(container);
            });

            // Altera o botão se houver exames
            if (exames.length > 0) {
                botao.textContent = 'Editar exames';
            } else {
                botao.textContent = 'Solicitar exame';
            }
        }

        //Função que exibe os remedios prescrevidos ao voltar para o prontuário
        window.addEventListener('DOMContentLoaded', () => {
            const medicamentos = JSON.parse(localStorage.getItem('medicamentos')) || [];
            const lista = document.getElementById('medicamentosPrescricao');
            const botao = document.getElementById('botaoPrescricao');

            medicamentos.forEach(med => {
                const container = document.createElement('div');
                container.classList.add('lista-medicamentos');

                const li = document.createElement('li');
                li.textContent = med;

                container.appendChild(li);
                lista.appendChild(container);
            });

            // Altera o botão se houver prescrições
            if (medicamentos.length > 0) {
                botao.textContent = 'Editar prescrição';
            } else {
                botao.textContent = 'Criar Prescrição';
            }
        });

        //Função que preenche o array dos exames solicitados
        document.querySelector('form').addEventListener('submit', function () {
        const exames = JSON.parse(localStorage.getItem('examesSolicitados')) || [];
        document.getElementById('examesSolicitadosInput').value = JSON.stringify(exames);
        });

    </script>
</body>
</html>
