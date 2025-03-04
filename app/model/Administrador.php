<?php

namespace App\Models;

require_once 'Usuario.php';

class Administrador extends Usuario {
    public function __construct(
        string $nome, 
        string $cpf, 
        string $telefone, 
        string $email, 
        string $senha) {
        parent::__construct($nome, $cpf, $telefone, $email, $senha, 'Administrador');
    }

    public function gerenciarSecretariosEMedicos() {
        return "Gerenciando secretários e médicos do sistema.";
    }    
}

$administrador = new Administrador('Adm Teste', '999.999.999-99', '(99)99999-9999', 'AdmTeste@.com', '123');
var_dump($administrador);
echo $administrador->gerenciarSecretariosEMedicos();
