<?php

namespace App\Models;

class Anamnese {
    public function __construct(
        private string $motivoConsulta,
        private string $queixaDuracao,
        private string $historiaDoencaAtual,
        private string $historiaSocial,
        private string $historiaGinecoObstetrica, //para mulheres
        private string $revisaoSistemas,
        
        private string $fatoresAgravantes,
        private string $atenuantes,
        
        private string $tratamentosPrevios,
        private string $respostaTratamentosPrevios,
    ) {}
}

$anamnese = new Anamnese(
    //queixa principal
    'Dor de cabeça intensa há 3 dias',

    //história da doença atual
    '3 dias atrás',
    'Duração teste',
    'Evolução teste',
    'Intensidade teste',
    'Localização teste',
    'Fatores agravantes teste',
    'Atenuantes teste',
    'Tratamentos prévios teste',
    'Resposta a tratamentos prévios teste',

    //história médica pregressa
    'Doenças anteriores teste',
    'Internações teste',
    'Cirurgias teste',
    'Uso contínuo de medicamentos teste',
    'Alergias conhecidas teste',


    //história familiar
    'Doenças genéticas teste',
    'Doenças crônicas teste',

    //história social
    'Hábitos teste',
    'Rotina alimentar teste',
    'Prática de atividades físicas teste',
    'Condições de moradia teste',
    'Exposições a fatores ambientais teste',

    //história gineco-obstétrica (para mulheres)
    'Regularidade da menstruação teste',
    'Fluxo da menstruação teste',
    'Cólicas teste',
    'Gestação anteriores teste',
    'Partos teste',
    'Uso de contraceptivos teste',

    //investigação de sintomas em diferentes sistemas do organismo
    'Sintomas cardiovasculares teste',
    'Sintomas respiratórios teste',
    'Sintomas gastroinstestinais teste',
    'Sintomas nervosos teste'
);

//var_dump($anamnese);
