<?php

    require_once '../controller/ConsultaController.php';
    $controller = new ConsultaController;
    $consultas = $controller->listarTodasConsultas();

    $consultasFormatadas = array_map(function($item) {
        /** @var Consulta $consulta */
        $consulta = $item['consulta'];
        
        return [
            'id' => $consulta->getId(),
            'title' => $consulta->getMotivo(),
            'start' => $consulta->getDataInicio(),
            'end' => $consulta->getDataFim(),
            'status' => $consulta->getStatus(),
            'nome_paciente' => $item['nome_paciente'],
            'nome_medico' => $item['nome_medico']
        ];
    }, $consultas);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Consultas</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/historico-consultas.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>

    <main>
        <section class="conteudo-principal">
            <h1>Histórico de Consultas</h1>

            <!-- Botões de filtro -->
            <div class="opcoes">
                <button id="opcao-todos" onclick="mostrar('todos')" class="opcao ativo">Todas</button>
                <button id="opcao-paciente" onclick="mostrar('paciente')" class="opcao">Paciente</button>
                <button id="opcao-medico" onclick="mostrar('medico')" class="opcao">Médico</button>
            </div>
            
            <!-- Filtro: Todos -->
            <section id="todos" class="filtro">
                <select name="" id="ordenacao-todos">
                    <option value="recentes">Mais recentes</option>
                    <option value="antigas">Mais antigas</option>
                </select>
            </section>

            <!-- Filtro: Médicos -->
            <section id="medicos" class="filtro oculto">
                <input type="text" id="input-medico" placeholder="Nome do médico">
                <select name="" id="ordenacao-medico">
                    <option value="recentes">Mais recentes</option>
                    <option value="antigas">Mais antigas</option>
                </select>
            </section>

            <!-- Filtro: Pacientes -->
            <section id="pacientes" class="filtro oculto">
                <input type="text" id="input-paciente" placeholder="Nome do paciente">
                <select name="" id="ordenacao-paciente">
                    <option value="recentes">Mais recentes</option>
                    <option value="antigas">Mais antigas</option>
                </select>
            </section>
            
            <section class="conteudo">
                <!--Legenda-->
                <section class="legenda">
                    <div class="legenda-paciente-medico">
                        <div class="legenda-paciente">
                            <h2>Paciente</h2>
                        </div>
                        <div class="legenda-data">
                            <h2>Data</h2>
                        </div>
                        <div class="legenda-medico">
                            <h2>Médico</h2>
                        </div>
                    </div>

                    <div class="legenda-prontuario">
                        <h2>Prontuário</h2>
                    </div>
                </section>

                <section id="lista-consultas">
                    
                </section>
            </section>

            <div class="botao">
                <button class="botao-vermelho" id="voltarPagina">Voltar</button>
            </div>

        </section>
    </main>

    <footer></footer>
    <script>
        const consultas = <?= json_encode($consultasFormatadas) ?>;
    </script>
    <script src="../../assets/script/historico-consultas.js"></script>
</body>
</html>