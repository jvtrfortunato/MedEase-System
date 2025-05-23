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
                        <!--Princípioativo-->
                        <div class="label-input">
                            <label for="medicamento">Princípio ativo / Medicamento <span class="azul">*</span></label>
                            <select name="medicamento" id="principioAtivo" required>
                                <option value="">Selecione o Medicamento</option>
                                <option value="DIPIRONA SODICA">DIPIRONA SÓDICA</option>
                                <option value="AMOXILINA">AMOXILINA</option>
                                <option value="LOSARTANA-POTASSICA">LOSARTANA POTÁSSICA</option>
                                <option value="METFORMINA">METFORMINA</option>
                                <option value="OMEPRAZOL">OMEPRAZOL</option>
                            </select>
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
                                    <option value="Comum">Comum</option>
                                    <option value="Controlada">Controlada</option>
                                </select>
                            </div>
                        </div>
                        <!--Posologia-->
                        <h2>Posologia</h2>
                        <div class="posologia">
                            <!--Dose-->
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
                            </div>

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
                                    <select name="">
                                        <option value="Dia">Dia(s)</option>
                                        <option value="Mes">Mes(es)</option>
                                        <option value="Ano">Ano(s)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--Recomendações-->
                        <h2>Recomendações</h2>
                        <textarea name="" id="" cols="86" rows="9"></textarea>
                        <!--PAREI AQUI-->
                        <!--IMPLEMENTAR OS BOTÕES AGORA-->
                    </form>
                    <div class="botoes">
                        <button class="vermelho" type="button" onclick="window.location.href='prontuario.php'">Voltar</button>
                        <div class="botoes-direita">
                            <button type="button" class="vermelho" onclick="limparCampos()">Limpar campos</button>
                            <button class="verde" type="button" onclick="salvarMedicamentos()">Salvar</button>
                        </div>
                    </div>
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
    <script>
        //Script posologia
        let tipoSelecionado = null;
        //Função para os botoes Dose única e Uso Contínuo
        function selecionarTipo(tipo) {
            const unica = document.getElementById('toggleUnica').parentElement;
            const continua = document.getElementById('toggleContinua').parentElement;

            if (tipo === 'unica') {
                if (tipoSelecionado === 'Dose única') {
                unica.classList.remove('ativo');
                tipoSelecionado = null;
                } else {
                unica.classList.add('ativo');
                continua.classList.remove('ativo');
                tipoSelecionado = 'Dose única';
                }
            } else if (tipo === 'continua') {
                if (tipoSelecionado === 'Uso contínuo') {
                continua.classList.remove('ativo');
                tipoSelecionado = null;
                } else {
                continua.classList.add('ativo');
                unica.classList.remove('ativo');
                tipoSelecionado = 'Uso contínuo';
                }
            }

            console.log('Tipo selecionado:', tipoSelecionado || 'nenhum');
        }

        //Função para alternar entre as labels Intervalo, Frequência e Turno
        function alternarLabels(tipo) {
          // Remove a classe 'ativo' de todos os labels
          document.querySelectorAll('.labels label').forEach(label => {
            label.classList.remove('ativo');
          });

          // Adiciona classe 'ativo' ao label clicado
          document.getElementById('label-' + tipo).classList.add('ativo');

          // Esconde todas as divs
          document.querySelectorAll('.frequencia-detalhe').forEach(div => {
            div.classList.remove('visivel');
          });

          // Mostra a div correspondente
          document.getElementById('conteudo-' + tipo).classList.add('visivel');
        }

        //Função para alternar entre as opções das labels Intervalo e Turno
        function selecionarOpcao(elemento) {
        // Remove a seleção de todos os elementos selecionáveis
        const todasAsOpcoes = document.querySelectorAll('.opcao-selecionavel');
        todasAsOpcoes.forEach(op => op.classList.remove('selecionado'));

        // Limpa os inputs manuais
        const inputs = document.querySelectorAll('.opcao-selecionavel[type="text"], .opcao-selecionavel[type="number"]');
        inputs.forEach(input => input.value = '');

        // Marca o elemento clicado ou focado como selecionado
        elemento.classList.add('selecionado');
        }

        //função que limpa todos os campos do formulário
        function limparCampos() {
            // Limpa todos os inputs (text, number, etc.)
            document.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(input => {
                input.value = '';
            });

            // Desmarca botões selecionáveis (como os de intervalo ou turno)
            document.querySelectorAll('button.selecionado').forEach(botao => {
                botao.classList.remove('selecionado');
            });

            // Desmarca botões de tipo de dose (Dose única / Uso contínuo)
            const toggleUnica = document.getElementById('toggleUnica');
            const toggleContinua = document.getElementById('toggleContinua');
            toggleUnica?.parentElement.classList.remove('ativo');
            toggleContinua?.parentElement.classList.remove('ativo');
            tipoSelecionado = null;

            // Recolhe divs expandidas, se quiser (opcional)
            document.querySelectorAll('.opcao-expandida').forEach(div => {
                div.style.display = 'none';
            });

            // Restaura seleção da aba "Intervalo", se quiser (opcional)
            selecionarAba('intervalo');
        }

        //Função para adicionar o nome de cada medicamento
        function adicionarMedicamento() {
            const principio = document.getElementById('principioAtivo');
            const concentracao = document.getElementById('concentracao');
            const forma = document.getElementById('forma');
            const via = document.getElementById('via');
            const tipoReceita = document.getElementById('tipoReceita');

            const intervaloSelecionado = document.querySelector('#conteudo-intervalo .opcao-selecionavel.selecionado');
            const intervaloInput = document.getElementById('input-intervalo');
            const frequenciaInput = document.getElementById('input-frequencia');
            const turnoSelecionado = document.querySelector('#conteudo-turno .opcao-selecionavel.selecionado');
            const algumHorarioPreenchido =
                intervaloSelecionado ||
                turnoSelecionado ||
                (intervaloInput && intervaloInput.value.trim() !== '') ||
                (frequenciaInput && frequenciaInput.value.trim() !== '');

            const inicioTratamento = document.getElementById('inicioTratamento');
            const duracao = document.getElementById('duracao');

            // Verifica se os campos obrigatórios foram preenchidos
            if (principio.value.trim() === '' || 
                concentracao.value.trim() === '' ||
                forma.value.trim() === '' ||
                via.value.trim() === '' ||
                tipoReceita.value.trim() === '' ||
                !algumHorarioPreenchido ||
                inicioTratamento.value.trim() === '' ||
                duracao.value.trim() === '' 
            ) {

                alert('Preencha todos os campos obrigatórios!');
                return;
            }

            // Cria item da lista
            const lista = document.getElementById('listaMedicamentos');
            
            const container = document.createElement('div');
            container.classList.add('item-lista');

            const li = document.createElement('li');
            
            const imgRemover = document.createElement('img');
            imgRemover.src = '/assets/img/lixeira.png'
            imgRemover.alt = 'Remover';
            imgRemover.classList.add('icone-remover');
            imgRemover.onclick = () => container.remove();

            li.textContent = principio.value.trim(); // você pode incluir a dose também se quiser
            
            container.appendChild(li);
            container.appendChild(imgRemover);
            lista.appendChild(container);

            // Limpa o formulário
            document.getElementById('form-medicamento').reset();
            document.querySelectorAll('.opcao-selecionavel.selecionado').forEach(el => el.classList.remove('selecionado'));
        }

        function salvarMedicamentos() {
            const lista = document.querySelectorAll('#listaMedicamentos .item-lista li');
            const medicamentos = [];

            lista.forEach(item => {
                medicamentos.push(item.textContent.trim());
            });

            if (medicamentos.length === 0) {
                alert('Nenhum medicamento foi adicionado!');
                return;
            }

            localStorage.setItem('medicamentos', JSON.stringify(medicamentos));
            window.location.href = 'prontuario.php';
        }

        function carregarMedicamentosSalvos() {
            const medicamentosSalvos = JSON.parse(localStorage.getItem('medicamentos'));

            if (medicamentosSalvos && Array.isArray(medicamentosSalvos)) {
                const lista = document.getElementById('listaMedicamentos');
                lista.innerHTML = '';

                medicamentosSalvos.forEach(nome => {
                    const container = document.createElement('div');
                    container.classList.add('item-lista');

                    const li = document.createElement('li');
                    li.textContent = nome;

                    const imgRemover = document.createElement('img');
                    imgRemover.src = '/assets/img/lixeira.png';
                    imgRemover.alt = 'Remover';
                    imgRemover.classList.add('icone-remover');
                    imgRemover.onclick = () => {
                        container.remove();
                        atualizarLocalStorage();
                    };

                    container.appendChild(li);
                    container.appendChild(imgRemover);
                    lista.appendChild(container);
                });
            }
        }

        function atualizarLocalStorage() {
            const lista = document.querySelectorAll('#listaMedicamentos .item-lista li');
            const medicamentosAtualizados = [];

            lista.forEach(item => {
                medicamentosAtualizados.push(item.textContent.trim());
            });

            localStorage.setItem('medicamentos', JSON.stringify(medicamentosAtualizados));
        }

        // Carrega medicamentos salvos ao abrir a página
        window.addEventListener('DOMContentLoaded', () => {
            carregarMedicamentosSalvos();
        });
    </script>
</body>
</html>