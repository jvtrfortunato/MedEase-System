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
        
        private string $intesidade,
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
