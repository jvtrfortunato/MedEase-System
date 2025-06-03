<?php

require_once 'Usuario.php';

class Administrador extends Usuario {
    public function __construct(
        string $idUsuario,
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
