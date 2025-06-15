<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Atestado</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/criar-atestado.css">
    <script src="../../assets/script/mascaraCPF.js"></script>
    <script src="../../assets/script/mascaraHORA.js"></script>
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    <main>
        <section class="conteudo-principal">
            <div class="tipos-atestado">
                <button type="button" id="btn-comparecimento" class="botao-tipo ativo" onclick="selecionarTipo('comparecimento')">Comparecimento</button>
                <button type="button" id="btn-afastamento" class="botao-tipo" onclick="selecionarTipo('afastamento')">Afastamento</button>
                <button type="button" id="btn-acompanhante" class="botao-tipo" onclick="selecionarTipo('acompanhante')">Acompanhante</button>
            </div>

            <h1>Informações do Paciente</h1>
            <section class="informacoes-paciente-medico">                    
                <div class="input-grande">
                    <label for="nomePaciente">Nome completo</label>
                    <input type="text" name="nomePaciente"> <!--O NOME SERÁ RESGATADO DO BANCO DE DADOS E INSERIDO AQUI AUTOMATICAMENTE-->
                </div>
                <div class="input-pequeno">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf"> <!--O CPF SERÁ RESGATADO DO BANCO DE DADOS E INSERIDO AQUI AUTOMATICAMENTE-->
                </div>
                <div class="input-pequeno">
                    <label for="dataNascimento">Data de nascimento</label>
                    <input type="date" name="dataNascimento"> <!--A DATA SERÁ RESGATADA DO BANCO DE DADOS E INSERIDA AQUI AUTOMATICAMENTE-->
                </div>
            </section>

            <h1>Informações do Médico</h1>
            <section class="informacoes-paciente-medico">
                <div class="input-grande">
                    <label for="nomeMedico">Nome completo</label>
                    <input type="text" name="nomeMedico" id=""> <!--O NOME SERÁ RESGATADO DO BANCO DE DADOS E INSERIDO AQUI AUTOMATICAMENTE-->
                </div>
                <div class="input-pequeno">
                    <label for="crm">CRM</label>
                    <input type="text" name="crm" id=""> <!--O CRM SERÁ RESGATADO DO BANCO DE DADOS E INSERIDO AQUI AUTOMATICAMENTE-->
                </div>
                <div class="input-pequeno">
                    <label for="especialidade">Especialidade</label>
                    <input type="text" name="especialidade" id=""> <!--A ESPECIALIDADE SERÁ RESGATADA DO BANCO DE DADOS E INSERIDA AQUI AUTOMATICAMENTE-->
                </div>
            </section>

            <form action="">
                <!-- Comparecimento -->
                <div id="form-comparecimento" class="formulario-atestado ativo">
                    <h1>Corpo do Atestado - Comparecimento</h1>
                    <section class="corpo-atestado">
                        <div class="dados-corpo">
                            <div class="input-pequeno">
                                <label for="data">Data</label>
                                <input type="date" name="data" id="">
                            </div>
                            <div class="input-pequeno">
                                <label for="horarioChegada">Horário de chegada</label>
                                <input type="text" name="horarioChegada" id="">
                            </div>
                        </div>
                        <div class="dados-corpo">
                            <div class="input-pequeno">
                                <label for="horarioSaida">Horário de saída</label>
                                <input type="text" name="horarioSaida" id="">
                            </div>
                            <div class="input-pequeno">
                                <label for="cid10">CID10</label>
                                <input type="text" name="cid10">
                            </div>
                        </div>
                        <div class="texto-principal">
                            <label for="textoPrincipal">Texto Principal</label>
                            <textarea name="textoPrincipal" id="" rows="15"></textarea>
                            <!-- Atesto, para os devidos fins, que o(a) Sr(a). [NOME DO PACIENTE], CPF [CPF DO PACIENTE], compareceu nesta unidade de saúde no dia [DATA], das [HORA DE INÍCIO] às [HORA DE TÉRMINO], para atendimento médico.
                            Por este motivo, recomenda-se a sua liberação das atividades durante o referido período.
                            Justificativa (opcional): [JUSTIFICATIVA] -->
                        </div>
                    </section>
                </div>
                
                <!-- Afastamento -->   
                <div id="form-afastamento" class="formulario-atestado">
                    <h1>Corpo do Atestado - Afastamento</h1>
                    <section class="corpo-atestado">
                        <div class="dados-corpo">
                            <div class="input-pequeno">
                                <label for="numeroDias">Nº de dias de afastamento</label>
                                <input type="number" name="numeroDias" id="">
                            </div>
                            <div class="input-pequeno">
                                <label for="dataInicio">Data de início do afastamento</label>
                                <input type="date" name="dataInicio" id="">
                            </div>
                        </div>
                        <div class="dados-corpo">
                            <div class="input-pequeno">
                                <label for="dataRetorno">Data de retorno previsto</label>
                                <input type="date" name="dataRetorno" id="">
                            </div>
                            <div class="input-pequeno">
                                <label for="cid10">CID10</label>
                                <input type="text" name="cid10">
                            </div>
                        </div>
                        <div class="texto-principal">
                            <label for="textoPrincipal">Texto Principal</label>
                            <textarea name="textoPrincipal" id="" rows="15"></textarea>
                            <!-- Atesto, para os devidos fins, que o(a) paciente [NOME DO PACIENTE], CPF [CPF DO PACIENTE], foi atendido(a) nesta data e, após avaliação clínica, necessita de afastamento de suas atividades habituais por um período de [NÚMERO DE DIAS] dias, a contar de [DATA DE INÍCIO], por motivos de saúde.
                            CID-10: [CÓDIGO CID-10]
                            Recomenda-se repouso e acompanhamento médico conforme necessário. -->
                        </div>
                    </section>
                </div>

                <!-- Acompanhante -->
                <div id="form-acompanhante" class="formulario-atestado">
                    <h1>Corpo do Atestado - Acompanhante</h1>
                    <section class="corpo-atestado">
                        <div class="dados-corpo">
                            <div class="input-pequeno">
                                <label for="nomeAcompanhante">Nome do acompanhante</label>
                                <input type="text" name="nomeAcompanhante" id="">
                            </div>
                            <div class="input-pequeno">
                                <label for="cpfAcompanhante">CPF do acompanhante</label>
                                <input type="text" name="cpfAcompanhante" id="">
                            </div>
                        </div>                
                        <div class="dados-corpo">
                            <div class="input-pequeno">
                                <label for="parentesco">Parentesco</label>
                                <input type="text" name="parentesco" id="">
                            </div>
                        </div>

                        <div class="dados-corpo">
                            <div class="input-pequeno">
                                <label for="data">Data</label>
                                <input type="date" name="data" id="">
                            </div>
                            <div class="input-pequeno">
                                <label for="horarioChegada">Horário de chegada</label>
                                <input type="text" name="horarioChegada" id="">
                            </div>
                        </div>
                        <div class="dados-corpo">
                            <div class="input-pequeno">
                                <label for="horarioSaida">Horário de saída</label>
                                <input type="text" name="horarioSaida" id="">
                            </div>
                            <div class="input-pequeno">
                                <label for="cid10">CID10</label>
                                <input type="text" name="cid10">    
                            </div>
                        </div>
                        <div class="texto-principal">
                            <label for="textoPrincipal">Texto Principal</label>
                            <textarea name="textoPrincipal" id="" rows="15" cols="15"></textarea>
                            <!-- Atesto, para os devidos fins, que o(a) Sr(a). [NOME DO ACOMPANHANTE], CPF [CPF DO ACOMPANHANTE], acompanhou o(a) paciente [NOME DO PACIENTE], CPF [CPF DO PACIENTE], durante atendimento médico realizado nesta unidade de saúde no dia [DATA], das [HORA DE INÍCIO] às [HORA DE TÉRMINO].
                            O acompanhamento foi necessário devido à condição clínica do(a) paciente no momento da consulta.
                            Justificativa (opcional): [JUSTIFICATIVA] -->
                        </div>
                    </section>
                </div>

                <div class="botoes">
                    <button type="button" class="vermelho" onclick="window.location.href='prontuario.php'">Voltar</button>
                    <button class="verde">Salvar</button>
                </div>
            </form>
            
        </section>
    </main>
    <footer></footer>
    <script src="../../assets/script/criar-atestado.js"></script>
</body>
</html>