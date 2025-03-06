<?php

namespace App\Models;

class Anamnese {
    public function __construct(
        //queixa principal
        private string $queixaPrincipal,

        
        //história da doença atual
        private string $inicioSintomas,
        
        private string $duracao,
        private string $evolucao,
        
        private string $intensidade,
        private string $localizacao,
        
        private string $fatoresAgravantes,
        private string $atenuantes,
        
        private string $tratamentosPrevios,
        private string $respostaTratamentosPrevios,

        
        //história médica pregressa
        private string $doencasAnteriores,

        private string $internacoes,
        private string $cirurgias,

        private string $usoMedicamentosContinuos,
        private string $alergiasConhecidas,

        
        //história familiar
        private string $doencasGeneticasFamilia,
        private string $doencasCronicasFamilia,


        //história social
        private string $habitosVida, //(tabagismo, etilismo, uso de drogas)
        
        private string $rotinaAlimentar,
        private string $praticaAtividadesFisicas,

        private string $condicoesMoradia,
        private string $exposicaoFatoresAmbientais,


        //história gineco-obstétrica (para mulheres)
        //ciclo menstrual
        private string $regularidadeMenstruacao,
        private string $fluxoMenstruacao,
        private string $colicas,

        private string $gestacaoAnteriores,
        private string $partos,
        private string $usoContraceptivos,


        //revisão de sistemas
        //investigação de sintomas em diferentes sistemas do organismo
        private string $sintomasCardiovasculares,
        private string $sintomasRespiratorios,
        private string $sintomasGastrointestinais,
        private string $sintomasNervosos,
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
