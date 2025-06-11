<?php

session_start();

require_once 'StatusConsulta.php';
require_once '../config/Database.php'; // Certifique-se de ajustar o caminho correto

class Consulta {
    private $conn;

    public function __construct(
<<<<<<< HEAD
        private int $idConsulta = 0,
        private string $motivo = '',
        private string $data = '',
        private string $hora = '',
        private string $status = '',
=======
        private int $idConsulta,
        private string $motivo,
        private string $cor,
        private string $dataInicio,
        private string $dataFim,
        //private StatusConsulta $status, USAR ENUM OU NÃO?
        private string $status,
>>>>>>> 7e337852eeeabaa1d2795b6000fc731227fc6e25
        private ?int $idAdministrador = null,
        private ?int $idSecretario = null,
        private int $idMedico = 0,
        private int $idPaciente = 0
    ) {
       $database = new Database();
    $this->conn = $database->conectar();
    }

    // Getters
<<<<<<< HEAD
    public function getId(): int { return $this->idConsulta; }
    public function getMotivo(): string { return $this->motivo; }
    public function getData(): string { return $this->data; }
    public function getHora(): string { return $this->hora; }
    public function getStatus(): string { return $this->status; }
    public function getIdPaciente(): int { return $this->idPaciente; }
    public function getIdMedico(): int { return $this->idMedico; }
    public function getIdSecretario(): ?int { return $this->idSecretario; }
    public function getIdAdministrador(): ?int { return $this->idAdministrador; }

    // Setters
    public function setMotivo(string $motivo): void { $this->motivo = $motivo; }
    public function setData(string $data): void { $this->data = $data; }
    public function setHora(string $hora): void { $this->hora = $hora; }
    public function setStatus(string $status): void { $this->status = $status; }
    public function setIdPaciente(int $idPaciente): void { $this->idPaciente = $idPaciente; }
    public function setIdMedico(int $idMedico): void { $this->idMedico = $idMedico; }
    public function setIdSecretario(int $idSecretario): void { $this->idSecretario = $idSecretario; }
    public function setIdAdministrador(int $idAdministrador): void { $this->idAdministrador = $idAdministrador; }

    // // Buscar todas as consultas (ADMIN pode usar)
    // public function buscarTodas() {
    //     $sql = "SELECT * FROM consultas";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // // Buscar consultas por médico (para restringir por médico)
    // public function buscarPorMedico($idMedico) {
    //     $sql = "SELECT * FROM consultas WHERE id_Medico = :id_Medico";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bindParam(':id_Medico', $idMedico);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
=======
    public function getId(): int {
        return $this->idConsulta;
    }

    public function getMotivo(): string {
        return $this->motivo;
    }

    public function getCor(): string {
        return $this->cor;
    }

    public function getDataInicio(): string {
        return $this->dataInicio;
    }

    public function getDataFim(): string {
        return $this->dataFim;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function getIdPaciente(): int {
        return $this->idPaciente;
    }

    public function getIdMedico(): int {
        return $this->idMedico;
    }

    public function getIdSecretario(): int {
        return $this->idSecretario;
    }

    public function getIdAdministrador(): int {
        return $this->idAdministrador;
    }

    // Setters
    public function setId(int $idConsulta): void {
        $this->idConsulta = $idConsulta;
    }

    public function setMotivo(string $motivo): void {
        $this->motivo = $motivo;
    }

    public function setCor(string $cor): void {
        $this->cor = $cor;
    }

    public function setDataInicio(string $dataInicio): void {
        $this->dataInico = $dataInicio;
    }

    public function setDataFim(string $dataFim): void {
        $this->dataFim = $dataFim;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function setIdPaciente(int $idPaciente): void {
        $this->idPaciente = $idPaciente;
    }

    public function setIdMedico(int $idMedico): void {
        $this->idMedico = $idMedico;
    }

    public function setIdSecretario(int $idSecretario): void {
        $this->idSecretario = $idSecretario;
    }

    public function setIdAdministrador(int $idAdministrador): void {
        $this->idAdministrador = $idAdministrador;
    }
>>>>>>> 7e337852eeeabaa1d2795b6000fc731227fc6e25
}
