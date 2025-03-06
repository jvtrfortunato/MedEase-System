<?php

namespace App\Models;

class ExameFisico {
    public function __construct(
        //Avaliação geral
        private string $nivelConsciencia, // --- Declarada em dois lugares, descobrir onde deixa-la - linha 67
        private string $posicaoEPostura,
        private string $facies,
        private string $estadoNutricional,
        private string $hidratacao,
        private string $coloracaoPele,

        //Sinais vitais
        private string $pressaoArterial,
        private string $frequenciaCardiaca,
        private string $frequenciaRespiratoria,
        private string $temperaturaCorporal,
        private string $saturacaoOxigenio, //Mede a oxigenação do sangue

        
        //Exame da pele e anexos (cabelos, unhas, mucosas)
        private string $lesoes,
        private string $manchas,
        private string $feridas,
        private string $hematomas,

        private string $elasticidadePele,
        private string $umidadePele,

        private string $coloracaoMuscosas,


        //exame da cabeça e pescoço
        private string $couroCabeludo,
        private string $cranio,

        private string $exameOlhos,
        private string $avaliacaoBocaGarganta,
        private string $linfonodosCervicais,
        private string $tireoide,


        //exame cardiovascular
        private string $toraxCardiovascular,
        private string $precordio,
        private string $auscultaCardiaca,
        private string $pulsosPerifericos,


        //exame respiratório
        private string $movimentoRespiratorio,
        private string $toraxRespiratorio,
        private string $percussaoToracica,
        private string $auscultaPulmonar,


        //exame abdominal
        private string $inspecao,
        private string $auscultaIntestinal,
        private string $percussaoAbdominal,
        private string $palpacaoAbdominal,


        //exame neurologico
        //private string $nivelConsciencia, --- Declarada em dois lugares, descobrir onde deixa-la
        private string $testeReflexos,
        private string $forcaMuscular, //--- Declarada em dois lugares, descobrir onde deixa-la - linha 76
        private string $coordenacaoMotora,
        private string $sensibilidade,


        //exame do aparelho locomotor
        private string $inspecaoArticulacoes,
        //private string $forcaMuscular, --- Declarada em dois lugares, descobrir onde deixa-la
        private string $amplitudeMovimentos,
        private string $dor,
        private string $limitacaoFuncional,
    ){}
}

$exameFisico = new ExameFisico(
    //Avaliação geral
    'Nível de consciência teste',
    'Posição e postura teste',
    'Facies teste',
    'Estado nutricional teste',
    'Hidratação teste',
    'Coloração da pele teste',

    //Sinais vitais
    'Pressão arterial teste',
    'Frequência cardíaca teste',
    'Frequência respiratória teste',
    'Temperatura corporal teste',
    'Saturação do oxigênio teste',

    //Exame da pele e anexos (cabelos, unhas, mucosas)
    'Lesões teste',
    'Manchas teste',
    'Feridas teste',
    'Hematomas teste',
    'Elasticidade da pele teste',
    'Umidade da pele teste',
    'Coloração das mucosas teste',

    //Exame da cabeça e pescoço
    'Couro cabeludo teste',
    'Crânio teste',
    'Olhos teste',
    'Avaliação da boca e garganta teste',
    'Linfonodos cervicais teste',
    'Tireoide teste',

    //Exame cardiovascular
    'Inspeção cardiovascular do tórax teste',
    'Precórdio teste',
    'Ausculta cardíaca teste',
    'Pulsos periféricos teste',

    //Exame respiratório
    'Movimento respiratório teste',
    'Inspeção respiratória do tórax teste',
    'Percussão torácica teste',
    'Ausculta pulmonar teste',

    //Exame abdominal
    'Inspeção abdominal teste',
    'Ausculta intestinal teste',
    'Percussão abdominal teste',
    'Palpação abdominal teste',

    //Exame neurológico
    'Teste de reflexos teste',
    'Força muscular teste',
    'Coordenação motora teste',
    'Sensibilidade teste',

    //Exame do aparelho locomotor
    'Inspeção das articulações teste',
    'Amplitude dos movimentos teste',
    'Dor teste',
    'Limitação funcional teste'
);

//var_dump($exameFisico);
