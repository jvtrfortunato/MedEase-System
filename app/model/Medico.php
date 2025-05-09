<?php

require_once '../config/database.php';
require_once 'Usuario.php';
require_once 'Endereco.php';

class Medico extends Usuario
{
    private string $crm;
    private string $especialidade;

    public function __construct(
        int $idUsuario,
        string $nome,
        string $cpf,
        string $telefone,
        string $dataNascimento,
        string $sexo,
        string $email,
        string $senha,
        string $crm,
        string $especialidade
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
            'medico', // tipo fixado como 'medico'
        );

        $this->crm = $crm;
        $this->especialidade = $especialidade;
    }

    // Getters

    public function getCrm(): string
    {
        return $this->crm;
    }

    public function getEspecialidade(): string
    {
        return $this->especialidade;
    }

    // Setters
    public function setCrm(string $crm): void
    {
        $this->crm = $crm;
    }

    public function setEspecialidade(string $especialidade): void
    {
        $this->especialidade = $especialidade;
    }

    // Métodos úteis
    public function toArray(): array
    {
        return [
            'idUsuario' => $this->getIdUsuario(),
            'nome' => $this->getNome(),
            'cpf' => $this->getCpf(),
            'telefone' => $this->getTelefone(),
            'dataNascimento' => $this->getDataNascimento(),
            'sexo' => $this->getSexo(),
            'email' => $this->getEmail(),
            'senha' => $this->getSenha(),
            'tipo' => $this->getTipo(),
            'crm' => $this->crm,
            'especialidade' => $this->especialidade,
            'endereco' => $this->getEndereco()->toArray()
        ];
    }
}
