<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Prescrição</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/criar-prescricao.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>
    <main>
        <section class="conteudo-principal">
            <section class="adicionar-medicamentos">
                <h1>ADICIONAR MEDICAMENTOS</h1>
            </section>

            <div class="dados-lista">
                <section class="dados-medicamento">
                    <form id="form-medicamento" action="">
                        <input type="hidden" name="medicamentosJSON" id="medicamentosJSON">
                        <!--Princípioativo-->
                        <div class="label-input">
                            <label for="medicamento">Princípio ativo / Medicamento <span class="azul">*</span></label>
                            <input type="text" name="medicamento" id="principioAtivo" required>
                        </div>
                        <!--Concentração até Forma farmaceutica-->
                        <div class="concentracao-forma">
                            <div class="label-input-media">
                                <label for="concentracao">Concentração <span class="azul">*</span></label>
                                <input type="text" name="concentracao" id="concentracao" required>
                            </div>
                            <div class="label-input-media">
                                <label for="forma">Forma farmaceutica <span class="azul">*</span></label>
                                <input type="text" name="forma" id="forma" required>
                            </div>
                        </div>
                        <!--Via de administração até Tipo de receita-->
                        <div class="via-tipo">
                            <div class="label-input-media">
                                <label for="via">Via de administração <strong class="azul">*</strong></label>
                                <input type="text" name="via" id="via" required>
                            </div>
                            <div class="label-input-media">
                                <label for="receita">Tipo de receita <span class="azul">*</span></label>
                                <select name="receita" id="tipoReceita" required>
                                    <option value="">Selecione</option>
                                    <option value="simples">Simples</option>
                                    <option value="controle">Controle especial</option>
                                    <option value="azul">Azul</option>
                                    <option value="amarela">Amarela</option>
                                </select>
                            </div>
                        </div>

                        <!-- Posologia -->
                        <h2>Posologia</h2>
                        <div class="posologia">

                            <!--PENSAR SE IMPLEMENTAREMOS ISSO-->
                            <!-- Dose 
                            <div class="dose-uso">
                                <div class="dose-esquerda">
                                    <label for="dose">Dose <strong class="azul">*</strong></label>
                                    <input type="text" name="dose" id="dose" required>
                                </div>
                                <div class="dose-direita">
                                    <div class="toggle-div">
                                        <p>Dose única</p>
                                        <div class="toggle-opcao" onclick="selecionarTipo('unica')">
                                            <div class="toggle-circle" id="toggleUnica"></div>
                                        </div>
                                    </div>
                                    <div class="toggle-div">
                                        <p>Uso contínuo</p>
                                        <div class="toggle-opcao" onclick="selecionarTipo('continua')">
                                            <div class="toggle-circle" id="toggleContinua"></div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!--Frequência da dose-->
                            <h3>Frequência da dose</h3>
                            <!-- Labels de escolha -->
                            <div class="labels">
                                <label onclick="alternarLabels('intervalo')" id="label-intervalo" class="ativo">Intervalo</label>
                                <label onclick="alternarLabels('frequencia')" id="label-frequencia">Frequência</label>
                                <label onclick="alternarLabels('turno')" id="label-turno">Turno</label>
                            </div>

                            <!--Intervalo-->
                            <div id="conteudo-intervalo" class="frequencia-detalhe visivel">
                                <button type="button" class="opcao-selecionavel" onclick="selecionarOpcao(this)">4h</button>
                                <button type="button" class="opcao-selecionavel" onclick="selecionarOpcao(this)">6h</button>
                                <button type="button" class="opcao-selecionavel" onclick="selecionarOpcao(this)">8h</button>
                                <button type="button" class="opcao-selecionavel" onclick="selecionarOpcao(this)">12h</button>
                                <button type="button" class="opcao-selecionavel" onclick="selecionarOpcao(this)">24h</button>
                                <div class="insercao-manual">
                                    <input type="number" id="input-intervalo" class="opcao-selecionavel" onfocus="selecionarOpcao(this)">
                                    <p>h</p>
                                </div>
                            </div>

                            <!--Frequência-->
                            <div id="conteudo-frequencia" class="frequencia-detalhe">
                                <input type="text" id="input-frequencia" class="opcao-selecionavel" placeholder="Digite a frequência" onfocus="selecionarOpcao(this)">
                            </div>

                            <!--Turno-->
                            <div id="conteudo-turno" class="frequencia-detalhe">
                                <button type="button" class="opcao-selecionavel" onclick="selecionarOpcao(this)">Manhã</button>
                                <button type="button" class="opcao-selecionavel" onclick="selecionarOpcao(this)">Tarde</button>
                                <button type="button" class="opcao-selecionavel" onclick="selecionarOpcao(this)">Noite</button>
                            </div>
                        </div>

                        <!--Período de tratamento-->
                        <h2>Período de tratamento</h2>
                        <div class="inicio-duracao">
                            <div class="inicio">
                                <label for="data">Início <span class="azul">*</span></label>
                                <input type="date" name="data" id="inicioTratamento" required>
                            </div>
                            <div class="duracao">
                                <label for="">Duração <span class="azul">*</span></label>
                                <div class="duracao-input">
                                    <input type="number" id="duracao" required>
                                    <select name="" id="duracaoTipo">
                                        <option value="Dia(s)">Dia(s)</option>
                                        <option value="Mes(es)">Mes(es)</option>
                                        <option value="Ano(s)">Ano(s)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--Recomendações-->
                        <h2>Recomendações</h2>
                        <textarea name="" id="recomendacoes" cols="86" rows="9"></textarea>
                        
                        <div class="botoes">
                        <button class="vermelho" type="button" onclick="window.location.href='prontuario.php'">Voltar</button>
                        <div class="botoes-direita">
                            <button type="button" class="vermelho" onclick="limparCampos()">Limpar campos</button>
                            <button class="verde" id="botaoSalvarPrescricao" type="submit">Salvar</button>
                        </div>
                        </div>
                    </form>
                </section>

                <section class="lista-medicamentos">
                    <ul id="listaMedicamentos"></ul>
                    <div class="adicionar-medicamento" onclick="adicionarMedicamento()">
                        <h2>+ADICIONAR MEDICAMENTO</h2>
                    </div>
                </section>
            </div>
        </section>
    </main>
    <footer></footer>
    <script src="../../assets/script/criar-prescricao.js"></script>
</body>
</html>