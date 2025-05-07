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
        private int $idProntuario
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

$exameFisico = new ExameFisico(
    //Avaliação geral
    'Nível de consciência teste',
    'Posição e postura teste',
    'Facies teste',
    'Estado nutricional teste',
    'Hidratação teste',
    'Coloração da pele teste',

    //Sinais vitais
    'Pressão arterial teste',
    'Frequência cardíaca teste',
    'Frequência respiratória teste',
    'Temperatura corporal teste',
    'Saturação do oxigênio teste',

    //Exame da pele e anexos (cabelos, unhas, mucosas)
    'Lesões teste',
    'Manchas teste',
    'Feridas teste',
    'Hematomas teste',
    'Elasticidade da pele teste',
    'Umidade da pele teste',
    'Coloração das mucosas teste',

    //Exame da cabeça e pescoço
    'Couro cabeludo teste',
    'Crânio teste',
    'Olhos teste',
    'Avaliação da boca e garganta teste',
    'Linfonodos cervicais teste',
    'Tireoide teste',

    //Exame cardiovascular
    'Inspeção cardiovascular do tórax teste',
    'Precórdio teste',
    'Ausculta cardíaca teste',
    'Pulsos periféricos teste',

    //Exame respiratório
    'Movimento respiratório teste',
    'Inspeção respiratória do tórax teste',
    'Percussão torácica teste',
    'Ausculta pulmonar teste',

    //Exame abdominal
    'Inspeção abdominal teste',
    'Ausculta intestinal teste',
    'Percussão abdominal teste',
    'Palpação abdominal teste',

    //Exame neurológico
    'Teste de reflexos teste',
    'Força muscular teste',
    'Coordenação motora teste',
    'Sensibilidade teste',

    //Exame do aparelho locomotor
    'Inspeção das articulações teste',
    'Amplitude dos movimentos teste',
    'Dor teste',
    'Limitação funcional teste'
);

//var_dump($exameFisico);
