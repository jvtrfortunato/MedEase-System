<?php

namespace App\Models;

require_once 'Usuario.php';

class SuperAdministrador extends Usuario {
    public function __construct($nome, $email, $senha) {
        parent::__construct($nome, $email, $senha, 'SuperAdministrador');
    }

    public function gerenciarUsuarios() {
        return "Gerenciando todos os usuários do sistema.";
    }
}

$superAdministrador = new SuperAdministrador('Super Teste', 'SuperTeste@.com', '123');
var_dump($superAdministrador);
echo $superAdministrador->gerenciarUsuarios();
