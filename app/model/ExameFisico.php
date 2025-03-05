<?php

namespace App\Models;

class ExameFisico {
    public function __construct(
        //avaliação geral
        private string $nivelConsciencia, // --- Declarada em dois lugares, descobrir onde deixa-la
        private string $posicaoEPostura,
        private string $facies,
        private string $estadoNutricional,
        private string $hidratacao,
        private string $coloracaoPele,

        //sinais vitais
        private string $pressaoArterial,
        private string $frequenciaCardiaca,
        private string $frequenciaRespiratoria,
        private string $temperaturaCorporal,
        private string $saturacaoOxigenio,

        
        //exame da pele e anexos (cabelos, unhas, mucosas)
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
        private string $forcaMuscular, //--- Declarada em dois lugares, descobrir onde deixa-la
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
