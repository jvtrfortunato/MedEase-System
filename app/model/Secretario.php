<?php

require_once 'Usuario.php';
require_once 'Endereco.php';

class Secretario extends Usuario {
    public function __construct(
        int $idUsuario,
        string $nome, 
        string $cpf,
        string $telefone, 
        string $dataNascimento,
        string $sexo,
        string $email, 
        string $senha, 
        Endereco $endereco
    ) {
        parent::__construct(
            $idUsuario, 
            $nome, 
            $cpf, 
            $telefone,
            $dataNascimento,
            $sexo,
            $email, 
            $senha,
            'secretario',
            $endereco
        );
    }
}

