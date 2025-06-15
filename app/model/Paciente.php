<?php

require_once 'Endereco.php';
require_once '../config/Database.php';
require_once '../controller/PacienteController.php';

class Paciente {
    public function __construct(
        private int $idPaciente,
        private string $nome,
        private string $dataNascimento,
        private string $sexo,
        private string $estadoCivil,
        private string $cpf,
        private string $rg,
        private string $telefone,
        private string $email,
        private string $nomeResponsavel,
        private string $cns,
        private string $convenio,
        private string $planoSaude,
        private Endereco $endereco
    ) {}   

    // Getters
    public function getIdPaciente(): int {
        return $this->idPaciente;
    }
    
    public function getNome(): string {
        return $this->nome;
    }

    public function getDataNascimento(): string {
        return $this->dataNascimento;
    }

    public function getSexo(): string {
        return $this->sexo;
    }

    public function getEstadoCivil(): string {
        return $this->estadoCivil;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function getRg(): string {
        return $this->rg;
    }

    public function getTelefone(): string {
        return $this->telefone;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getNomeResponsavel(): string {
        return $this->nomeResponsavel;
    }

    public function getCns(): string {
        return $this->cns;
    }

    public function getConvenio(): string {
        return $this->convenio;
    }

    public function getPlanoSaude(): string {
        return $this->planoSaude;
    }

    public function getEndereco(): Endereco {
        return $this->endereco;
    }
    
    // Setters
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setDataNascimento(string $dataNascimento): void {
        $this->dataNascimento = $dataNascimento;
    }

    public function setSexo(string $sexo): void {
        $this->sexo = $sexo;
    }

    public function setEstadoCivil(string $estadoCivil): void {
        $this->estadoCivil = $estadoCivil;
    }
    
    public function setCpf(string $cpf): void {
        $this->cpf = $cpf;
    }

    public function setRg(string $rg): void {
        $this->rg = $rg;
    }

    public function setTelefone(string $telefone): void {
        $this->telefone = $telefone;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }
    
    public function setNomeResponsavel(string $nomeResponsavel): void {
        $this->nomeResponsavel = $nomeResponsavel;
    }

    public function setCns(string $cns): void {
        $this->cns = $cns;
    }

    public function setConvenio(string $convenio): void {
        $this->convenio = $convenio;
    }

    public function setPlanoSaude(string $planoSaude): void {
        $this->planoSaude = $planoSaude;
    }
    
    public function setEndereco(Endereco $endereco): void {
        $this->endereco = $endereco;
    }

    public static function buscarPorNome(PDO $conn, $nome): array {
        $sql = "SELECT * FROM pacientes WHERE nome LIKE ? ORDER BY nome ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%$nome%"]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pacientes = [];

        foreach ($rows as $row) {
            
            $sqlEnd = "SELECT * FROM enderecos WHERE id_paciente = ?";
            $stmtEnd = $conn->prepare($sqlEnd);
            $stmtEnd->execute([$row['id_paciente']]);
            $endRow = $stmtEnd->fetch(PDO::FETCH_ASSOC);

            if ($endRow) {
                $idUsuario = isset($endRow['id_Usuario']) && $endRow['id_Usuario'] !== '' ? (int)$endRow['id_Usuario'] : null;

                $endereco = new Endereco(
                    $endRow['logradouro'] ?? '',
                    $endRow['numero'] ?? '',
                    $endRow['complemento'] ?? '',
                    $endRow['bairro'] ?? '',
                    $endRow['cidade'] ?? '',
                    $endRow['estado'] ?? '',
                    $idUsuario
                );
            } else {
                // Caso não tenha endereço cadastrado
                $endereco = new Endereco('', '', '', '', '', '', null);
            }

            $pacientes[] = new Paciente(
                (int)$row['id_paciente'],
                $row['nome'] ?? '',
                $row['dataNascimento'] ?? '',
                $row['sexo'] ?? '',
                $row['estadoCivil'] ?? '',
                $row['cpf'] ?? '',
                $row['rg'] ?? '',
                $row['telefone'] ?? '',
                $row['email'] ?? '',
                $row['nomeResponsavel'] ?? '',
                $row['cns'] ?? '',
                $row['convenio'] ?? '',
                $row['planoSaude'] ?? '',
                $endereco
            );
        }

        return $pacientes;
    }


}
