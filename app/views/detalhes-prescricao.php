<?php

    require_once '../controller/ProntuarioController.php';

    //Busca o prontuário
    $prontuarioController = new ProntuarioController();
    $prontuario = $prontuarioController->visualizarProntuario($_GET['id_consulta']);

    //Conferir se existem medicamentos solicitados
    $medicamentosBanco = [];
    foreach ($prontuario->getPrescricao()->getMedicamentos() as $medicamento) {
        $medicamentosBanco[] = [
            'principioAtivo' => $medicamento->getNomeMedicamento(),
            'concentracao' => $medicamento->getConcentracao(),
            'formaFarmaceutica' => $medicamento->getFormaFarmaceutica(),
            'viaAdministracao' => $medicamento->getViaAdministracao(),
            'tipoReceita' => $medicamento->getTipoReceita(),
            'intervaloDose' => $medicamento->getIntervaloDose(),
            'frequenciaDose' => $medicamento->getFrequenciaDose(),
            'turnoDose' => $medicamento->getTurnoDose(),
            'inicioTratamento' => $medicamento->getDataInicio(),
            'quantidadeDuracao' => $medicamento->getQuantidadeDuracao(),
            'tipoDuracao' => $medicamento->getTipoDuracao()
        ];
    }

    //Armazenar o nome dos medicamentos
    $nomesMedicamentos = array_map(function($medicamento) {
        return $medicamento['principioAtivo'];
    }, $medicamentosBanco);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Prescrição</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/detalhes-prescricao.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>
    <main>
        <!--Lista dinãmica de medicamentos-->
        <section class="conteudo-principal">
            <section class="adicionar-medicamentos">
                <h1>DETALHES DOS MEDICAMENTOS</h1>
            </section>

            <div class="dados-lista">
                <section class="dados-medicamento">
                    <!--Princípioativo-->
                    <div class="label-input">
                        <label for="medicamento">Princípio ativo / Medicamento</label>
                        <div class="input" id="input-principioAtivo"></div>
                    </div>
                    <!--Concentração até Forma farmaceutica-->
                    <div class="concentracao-forma">
                        <div class="label-input-media">
                            <label for="concentracao">Concentração</label>
                            <div class="input" id="input-concentracao"></div>
                        </div>
                        <div class="label-input-media">
                            <label for="forma">Forma farmaceutica</label>
                            <div class="input" id="input-forma"></div>
                        </div>
                    </div>
                    <!--Via de administração até Tipo de receita-->
                    <div class="via-tipo">
                        <div class="label-input-media">
                            <label for="via">Via de administração</label>
                            <div class="input" id="input-via"></div>
                        </div>
                        <div class="label-input-media">
                            <label for="receita">Tipo de receita</label>
                            <div class="input" id="input-tipo-receita"></div>
                        </div>
                    </div>

                    <!-- Posologia -->
                    <h2>Frequência</h2>
                    <div class="input posologia" id="input-posologia"></div>

                    <!--Período de tratamento-->
                    <h2>Período de tratamento</h2>
                    <div class="inicio-duracao">
                        <div class="inicio">
                            <label for="data">Início</label>
                            <div class="input" id="input-inicio"></div>
                        </div>
                        <div class="duracao">
                            <label for="">Duração</label>
                            <div class="duracao-input">
                                <div class="input" id="input-duracao"></div>
                            </div>
                        </div>
                    </div>

                    <!--Recomendações-->
                    <h2>Recomendações</h2>  
                    <div class="input posologia"><?php echo htmlspecialchars($prontuario->getPrescricao()->getRecomendacoes()) ?></div>
                    
                    <div class="botoes">
                        <button class="vermelho" onclick="history.back()">Voltar</button>
                    </div>
                </section>

                <section class="lista-medicamentos">
                    <ul id="listaMedicamentos"></ul>
                </section>
            </div>
        </section>
    </main>
    <footer></footer>
    <script src="../../assets/script/detalhes-prescricao.js"></script>

    <script>
        const nomesMedicamentos = <?= json_encode($nomesMedicamentos) ?>;
        const medicamentos = <?= json_encode($medicamentosBanco, JSON_UNESCAPED_UNICODE) ?>;
        atualizarListaMedicamentos();
    </script>
</body>
</html>