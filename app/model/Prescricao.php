<?php

namespace App\Models;

class Prescricao {
    public function __construct(
        //medicamento
        private string $medicamento,
        private string $concentracao,
        private string $formaFarmaceutica,
        private string $viaAdministracao,
        private string $tipoReceita,

        //posologia
        private string $dose,
        private string $frequenciaDose,

        //período de tratamento
        private string $inicio,
        private string $dias,

        //outros
        private string $recomendacoes
    ){}

    public function criarPrescricao() {
        return "Tela de criação de prescrição com todos os campos onde os dados serão inseridos.";
    }

    public function salvarMedicamento() {
        return "Armazena o medicamento em uma lista.";
    }

    public function finalizarPrescricao() {
        return "Une os medicamentos em uma prescricao e a armazena no prontuário do paciente";
    }
}

$prescricao = new Prescricao(
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
    'Recomendações teste'
);

//var_dump($prescricao);
