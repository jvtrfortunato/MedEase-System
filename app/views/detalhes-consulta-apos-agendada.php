<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Consulta</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/detalhes-consulta.css">
    <script src="../../assets/script/detalhes-consulta.js" defer></script>
    <script src="../../assets/script/botaoVoltar.js" defer></script>
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    
    <main>
        <section class="conteudo-principal">
            <h1>Descrição da Consulta</h1>
            <section class="dados-consulta">
                
                <div class="linha">
                    <div class="label-input">
                        <label for="motivo">Motivo</label>
                        <input type="text" name="motivo" id="">
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label for="data">Data</label>
                            <input type="date" name="data" id="">
                        </div>
                        <div class="label-input">
                            <label for="hora">Hora</label>
                            <input type="text" name="hora" id="">
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <label for="nome">Nome do Paciente</label>
                        <input type="text" name="nome" id="">
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="">
                        </div>
                        <div class="label-input">
                            <label for="telefone">Telefone</label>
                            <input type="tel" name="telefone" id="">
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <label for="medico">Médico</label>
                        <select name="medico" id="">
                            <option value="">Selecione</option>
                            <option value="">Médico 1</option>
                            <option value="">Médico 2</option>
                        </select>
                    </div>
                    <div class="label-input">
                        <label for="especialidade">Especialidade</label>
                        <select name="especialidade" id="">
                            <option value="">Selecione</option>
                            <option value="">Neurologia</option>
                            <option value="">Cardiologia</option>
                        </select>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <label for="salaAtendimento">Sala de atendimento</label>
                        <select name="salaAtendimento" id="">
                            <option value="">Selecione</option>
                            <option value="">Sala 1</option>
                            <option value="">Sala 2</option>
                        </select>
                    </div>
                </div>

            </section>
        </section>
        <div class="botoes">
            <button id="voltarPagina2"class="voltar">Voltar</button>
        </div>
    </main>
    
    <footer></footer>
    <script>
       

    </script>
</body>
</html>