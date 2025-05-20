<?php

class ExameFisico {
    public function __construct(
        private string $avaliacaoGeral,
        private string $sinaisVitais,
        private string $examePeleAnexos,
        private string $exameCabecaPescoco,
        private string $exameCardiovascular,
        private string $exameRespiratorio,
        private string $exameAbdominal,
        private string $exameNeurologico,
        private string $exameAparelhoLocomotor,
        private ?int $idProntuario = null
    ) {}

    // Getters
    public function getAvaliacaoGeral(): string {
        return $this->avaliacaoGeral;
    }

    public function getSinaisVitais(): string {
        return $this->sinaisVitais;
    }

    public function getExamePeleAnexos(): string {
        return $this->examePeleAnexos;
    }

    public function getExameCabecaPescoco(): string {
        return $this->exameCabecaPescoco;
    }

    public function getExameCardiovascular(): string {
        return $this->exameCardiovascular;
    }

    public function getExameRespiratorio(): string {
        return $this->exameRespiratorio;
    }

    public function getExameAbdominal(): string {
        return $this->exameAbdominal;
    }

    public function getExameNeurologico(): string {
        return $this->exameNeurologico;
    }

    public function getExameAparelhoLocomotor(): string {
        return $this->exameAparelhoLocomotor;
    }

    public function getIdProntuario(): int {
        return $this->idProntuario;
    }

    // Setters
    public function setAvaliacaoGeral(string $avaliacaoGeral): void {
        $this->avaliacaoGeral = $avaliacaoGeral;
    }

    public function setSinaisVitais(string $sinaisVitais): void {
        $this->sinaisVitais = $sinaisVitais;
    }

    public function setExamePeleAnexos(string $examePeleAnexos): void {
        $this->examePeleAnexos = $examePeleAnexos;
    }

    public function setExameCabecaPescoco(string $exameCabecaPescoco): void {
        $this->exameCabecaPescoco = $exameCabecaPescoco;
    }

    public function setExameCardiovascular(string $exameCardiovascular): void {
        $this->exameCardiovascular = $exameCardiovascular;
    }

    public function setExameRespiratorio(string $exameRespiratorio): void {
        $this->exameRespiratorio = $exameRespiratorio;
    }

    public function setExameAbdominal(string $exameAbdominal): void {
        $this->exameAbdominal = $exameAbdominal;
    }

    public function setExameNeurologico(string $exameNeurologico): void {
        $this->exameNeurologico = $exameNeurologico;
    }

    public function setExameAparelhoLocomotor(string $exameAparelhoLocomotor): void {
        $this->exameAparelhoLocomotor = $exameAparelhoLocomotor;
    }

    public function setIdProntuario(int $idProntuario): void {
        $this->idProntuario = $idProntuario;
    }
}
