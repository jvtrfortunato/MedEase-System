<?php

namespace App\Models;

class Prescricao {
    public function __construct(
        //Medicamento
        private string $nomeMedicamento,
        private string $concentracao,
        private string $formaFarmaceutica,
        private string $viaAdministracao,
        private string $tipoReceita,

        //Posologia
        private string $dose,
        private string $frequenciaDose,

        //Período de tratamento
        private string $dataInicio,
        private int $quantidadeDuracao,
        private string $diaMesOuAno,
        
        //Recomendações
        private string $recomendacoes
    ){}
}

$medicamento = new Medicamento(
    //Medicamento
    'Medicamento teste',
    'Concentração teste',
    'Forma farmaceutica teste',
    'Via administração teste',
    'Tipo receita teste',

    //Posologia
    'Dose teste',
    'Frequência dose teste',

    //Período de tratamento
    'Início teste',
    'Dias teste',
    
    //Outros
    'Recomendações teste'   //ARRUMAR TODOS DESSE AQUI
);

//var_dump($medicaento);