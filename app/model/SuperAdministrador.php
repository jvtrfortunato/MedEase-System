<?php

namespace App\Models;

require_once 'Usuario.php';

class SuperAdministrador extends Usuario {
    public function __construct(
        string $nome, 
        string $cpf, 
        string $telefone, 
        string $email, 
        string $senha
    ) {
        parent::__construct($nome, $cpf, $telefone, $email, $senha, 'SuperAdministrador');
    }

    public function gerenciarUsuarios() {
        return "Gerenciando todos os usuários do sistema.";
    }
}

$superAdministrador = new SuperAdministrador('Super Teste', '999.999.999-99', '(99)99999-9999', 'SuperTeste@.com', '123');
var_dump($superAdministrador);
echo $superAdministrador->gerenciarUsuarios();
