<?php

namespace App\Models;

require_once 'Medicamento.php';

class Prescricao {
    public function __construct(
        private Medicamento $medicamentos = []
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


