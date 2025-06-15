<?php

    require_once '../controller/ProntuarioController.php';

    //Busca o prontuário
    $prontuarioController = new ProntuarioController();
    $prontuario = $prontuarioController->visualizarProntuario($_GET['id_consulta']);

    //Buscar o atestado
    $atestado = $prontuario->getDocumentacao()->getAtestado();
    $dadosAtestado = [];

    if ($atestado instanceof AtestadoAcompanhante) {
        $dadosAtestado = [
            'tipo' => 'acompanhante',
            'cid10' => $atestado->getCid10(),
            'textoPrincipal' => $atestado->getTextoPrincipal(),
            'nomeAcompanhante' => $atestado->getNomeAcompanhante(),
            'cpfAcompanhante' => $atestado->getCpfAcompanhante(),
            'parentescoAcompanhante' => $atestado->getParentescoAcompanhante(),
            'data' => $atestado->getData(),
            'horarioChegada' => $atestado->getHorarioChegada(),
            'horarioSaida' => $atestado->getHorarioSaida()
        ];
    } elseif ($atestado instanceof AtestadoAfastamento) {
        $dadosAtestado = [
            'tipo' => 'afastamento',
            'cid10' => $atestado->getCid10(),
            'textoPrincipal' => $atestado->getTextoPrincipal(),
            'diasAfastamento' => $atestado->getDiasAfastamento(),
            'dataInicio' => $atestado->getDataInicio(),
            'dataRetorno' => $atestado->getDataRetorno()
        ];
    } elseif ($atestado instanceof AtestadoComparecimento) {
        $dadosAtestado = [
            'tipo' => 'comparecimento',
            'cid10' => $atestado->getCid10(),
            'textoPrincipal' => $atestado->getTextoPrincipal(),
            'data' => $atestado->getData(),
            'horarioChegada' => $atestado->getHorarioChegada(),
            'horarioSaida' => $atestado->getHorarioSaida()
        ];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atestado</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/detalhes-atestado.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>
    <main>
        <section class="conteudo-principal">
            <!-- Comparecimento -->
            <div id="form-comparecimento" class="formulario-atestado">
                <h1>Corpo do Atestado - Comparecimento</h1>
                <section class="corpo-atestado">
                    <div class="dados-corpo">
                        <div class="input-pequeno">
                            <label>Data</label>
                            <div class="input" id="data-comparecimento"></div>
                        </div>
                        <div class="input-pequeno">
                            <label>Horário de chegada</label>
                            <div class="input" id="chegada-comparecimento"></div>
                        </div>
                    </div>
                    <div class="dados-corpo">
                        <div class="input-pequeno">
                            <label>Horário de saída</label>
                            <div class="input" id="saida-comparecimento"></div>
                        </div>
                        <div class="input-pequeno">
                            <label>CID10</label>
                            <div class="input" id="cid-comparecimento"></div>
                        </div>
                    </div>
                    <div class="texto-principal">
                        <label>Texto Principal</label>
                        <div class="input" id="texto-comparecimento"></div>
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
                            <label>Nº de dias de afastamento</label>
                            <div class="input" id="dias-afastamento"></div>
                        </div>
                        <div class="input-pequeno">
                            <label>Data de início do afastamento</label>
                            <div class="input" id="inicio-afastamento"></div>
                        </div>
                    </div>
                    <div class="dados-corpo">
                        <div class="input-pequeno">
                            <label>Data de retorno previsto</label>
                            <div class="input" id="retorno-afastamento"></div>
                        </div>
                        <div class="input-pequeno">
                            <label>CID10</label>
                            <div class="input" id="cid-afastamento"></div>
                        </div>
                    </div>
                    <div class="texto-principal">
                        <label>Texto Principal</label>
                        <div class="input" id="texto-afastamento"></div>
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
                            <label>Nome do acompanhante</label>
                            <div class="input" id="nome-acompanhante"></div>
                        </div>
                        <div class="input-pequeno">
                            <label>CPF do acompanhante</label>
                            <div class="input" id="cpf-acompanhante"></div>
                        </div>
                    </div>                
                    <div class="dados-corpo">
                        <div class="input-pequeno">
                            <label>Parentesco</label>
                            <div class="input" id="parentesco-acompanhante"></div>
                        </div>
                    </div>

                    <div class="dados-corpo">
                        <div class="input-pequeno">
                            <label>Data</label>
                            <div class="input" id="data-acompanhante"></div>
                        </div>
                        <div class="input-pequeno">
                            <label>Horário de chegada</label>
                            <div class="input" id="chegada-acompanhante"></div>
                        </div>
                    </div>
                    <div class="dados-corpo">
                        <div class="input-pequeno">
                            <label>Horário de saída</label>
                            <div class="input" id="saida-acompanhante"></div>
                        </div>
                        <div class="input-pequeno">
                            <label>CID10</label>
                            <div class="input" id="cid-acompanhante"></div>    
                        </div>
                    </div>
                    <div class="texto-principal">
                        <label>Texto Principal</label>
                        <div class="input" id="texto-acompanhante"></div>
                        <!-- Atesto, para os devidos fins, que o(a) Sr(a). [NOME DO ACOMPANHANTE], CPF [CPF DO ACOMPANHANTE], acompanhou o(a) paciente [NOME DO PACIENTE], CPF [CPF DO PACIENTE], durante atendimento médico realizado nesta unidade de saúde no dia [DATA], das [HORA DE INÍCIO] às [HORA DE TÉRMINO].
                        O acompanhamento foi necessário devido à condição clínica do(a) paciente no momento da consulta.
                        Justificativa (opcional): [JUSTIFICATIVA] -->
                    </div>
                </section>
            </div>
            <div class="botoes">
                <button type="button" class="vermelho" onclick="history.back()">Voltar</button>
            </div>
        </section>
    </main>
    <footer></footer>
    <script src="../../assets/script/detalhes-atestado.js"></script>
    <script>
        const atestado = <?= json_encode($dadosAtestado, JSON_UNESCAPED_UNICODE) ?>;
    </script>
</body>
</html>