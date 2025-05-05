<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link href="../../assets/css/inserir-resultado-exame.css" rel="stylesheet">
    <title>Inserir Resultado Exame</title>
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>

    <main>
        <section>
            <h3 class="primeiroh3">Inserir Resultado de Exame</h3>

            <form action="#" method="POST">
                <div class="solicitacao">

                    <div class="lista-exames">
                        <label for="exame">Exame</label>
                        <select name="exame" id="exame">
                            <option value="" disabled selected>Ex: Hemograma</option>
                            <option value="Hemograma">Hemograma</option>
                            <option value="Eletrocardiograma">Eletrocardiograma</option>
                            <option value="Raio-X de Tórax">Raio-X de Tórax</option>
                        </select>
                    </div>                

                    <div class="grupo-solicitacao">
                        <div class="data-solicitacao">
                            <label for="data-solicitacao">Data de solicitação</label>
                            <input type="date" id="data-solicitacao" name="data_solicitacao" />
                        </div>    
                        <div class="solicitado-por">
                            <label for="solicitado-por">Solicitado por</label>
                            <p>MARIANA OLIVIA DO AMARAL</p>
                            <p>MÉDICA CARDIOLOGISTA</p>
                            <p>NOME DA CLÍNICA</p>
                        </div>
                    </div>
                </div>

                <div class="exame-especifico">
                    <label for="exame-especifico">Exame específico <label>
                    <select id="exame-especifico" name="exame_especifico">
                        <option value="">Nenhum exame específico selecionado</option>
                        <option value="exame1">Exame 1</option>
                        <option value="exame2">Exame 2</option>
                        <option value="exame3">Exame 3</option>
                    </select>
                </div>

                <h3>Resultados</h3>
                <div class="resultados">

                    <div class="grupo-data">
                        <div class="data-realizacao">
                            <label for="data-realizacao">Data de realização</label>
                            <input type="date" id="data-realizacao" name="data_realizacao" />
                        </div>

                        <div class="data-resultado">
                            <label for="data-resultado">Data do resultado</label>
                            <input type="date" id="data-resultado" name="data_resultado" />
                        </div>
                    </div>

                    <div class="campo-descricao">
                        <label for="descricao">Descrição</label>
                        <textarea id="descricao" name="descricao" rows="4" placeholder="Observações..."></textarea>
                    </div>
                </div>

                <div class="grupo-buttons">
                    <button type="button" class="btn voltar"><a href="#">Voltar</a></button>
                    <button type="submit" class="btn finalizar">Finalizar</button>
                </div>
            </form>
        </section>      
    </main>
</body>
</html>
