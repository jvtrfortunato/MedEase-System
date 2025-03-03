<?php

namespace App\Models;

require_once "Usuario.php";

class Secretario extends Usuario {
    public function __construct($nome, $email, $senha) {
        parent::__construct($nome, $email, $senha, 'Secretário');
    }

    public function gerenciarConsultas() {
        return "Agendando, atualizando consultas e excluindo agendamentos.";
    }
}

$secretario = new Secretario('Secretario Teste', 'SecTeste@.com', '123');
var_dump($secretario);
echo $secretario->gerenciarConsultas();
