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
        string $tipo,
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
            $tipo,
            $endereco
        );
    }
}

$secretario = new Secretario(
    1,
    'Secretario Teste', 
    '999.999.999-99', 
    '(99)99999-9999', 
    'SecTeste@.com', 
    '123', 
    'Secretário');

var_dump($secretario);
