<?php

namespace App\Models;

require_once 'Usuario.php';

class Administrador extends Usuario {
    public function __construct($nome, $email, $senha) {
        parent::__construct($nome, $email, $senha, 'Administrador');
    }

    public function gerenciarSecretariosEMedicos() {
        return "Gerenciando secretários e médicos do sistema.";
    }    
}

$administrador = new Administrador('Adm Teste', 'AdmTeste@.com', '123');
var_dump($administrador);
echo $administrador->gerenciarSecretariosEMedicos();