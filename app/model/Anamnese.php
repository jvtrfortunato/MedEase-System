<?php

namespace App\Models;

class Anamnese {
    public function __construct(
        private string $motivoConsulta,
        private string $queixaDuracao,
        private string $historiaDoencaAtual,
        private string $historiaSocial,
        private string $historiaGinecoObstetrica,
        private string $revisaoSistemas,
        private string $fatoresAgravantes,
        private string $atenuantes,
        private string $tratamentosPrevios,
        private string $respostaTratamentosPrevios,
        private int $idProntuario
    ) {}

    // Getters
    public function getMotivoConsulta(): string {
        return $this->motivoConsulta;
    }

    public function getQueixaDuracao(): string {
        return $this->queixaDuracao;
    }

    public function getHistoriaDoencaAtual(): string {
        return $this->historiaDoencaAtual;
    }

    public function getHistoriaSocial(): string {
        return $this->historiaSocial;
    }

    public function getHistoriaGinecoObstetrica(): string {
        return $this->historiaGinecoObstetrica;
    }

    public function getRevisaoSistemas(): string {
        return $this->revisaoSistemas;
    }

    public function getFatoresAgravantes(): string {
        return $this->fatoresAgravantes;
    }

    public function getAtenuantes(): string {
        return $this->atenuantes;
    }

    public function getTratamentosPrevios(): string {
        return $this->tratamentosPrevios;
    }

    public function getRespostaTratamentosPrevios(): string {
        return $this->respostaTratamentosPrevios;
    }

    public function getIdProntuario(): int {
        return $this->idProntuario;
    }

    // Setters
    public function setMotivoConsulta(string $motivoConsulta): void {
        $this->motivoConsulta = $motivoConsulta;
    }

    public function setQueixaDuracao(string $queixaDuracao): void {
        $this->queixaDuracao = $queixaDuracao;
    }

    public function setHistoriaDoencaAtual(string $historiaDoencaAtual): void {
        $this->historiaDoencaAtual = $historiaDoencaAtual;
    }

    public function setHistoriaSocial(string $historiaSocial): void {
        $this->historiaSocial = $historiaSocial;
    }

    public function setHistoriaGinecoObstetrica(string $historiaGinecoObstetrica): void {
        $this->historiaGinecoObstetrica = $historiaGinecoObstetrica;
    }

    public function setRevisaoSistemas(string $revisaoSistemas): void {
        $this->revisaoSistemas = $revisaoSistemas;
    }

    public function setFatoresAgravantes(string $fatoresAgravantes): void {
        $this->fatoresAgravantes = $fatoresAgravantes;
    }

    public function setAtenuantes(string $atenuantes): void {
        $this->atenuantes = $atenuantes;
    }

    public function setTratamentosPrevios(string $tratamentosPrevios): void {
        $this->tratamentosPrevios = $tratamentosPrevios;
    }

    public function setRespostaTratamentosPrevios(string $respostaTratamentosPrevios): void {
        $this->respostaTratamentosPrevios = $respostaTratamentosPrevios;
    }

    public function setIdProntuario(int $idProntuario): void {
        $this->idProntuario = $idProntuario;
    }
}


$anamnese = new Anamnese(
    //queixa principal
    'Dor de cabeça intensa há 3 dias',

    //história da doença atual
    '3 dias atrás',
    'Duração teste',
    'Evolução teste',
    'Intensidade teste',
    'Localização teste',
    'Fatores agravantes teste',
    'Atenuantes teste',
    'Tratamentos prévios teste',
    'Resposta a tratamentos prévios teste',

    //história médica pregressa
    'Doenças anteriores teste',
    'Internações teste',
    'Cirurgias teste',
    'Uso contínuo de medicamentos teste',
    'Alergias conhecidas teste',


    //história familiar
    'Doenças genéticas teste',
    'Doenças crônicas teste',

    //história social
    'Hábitos teste',
    'Rotina alimentar teste',
    'Prática de atividades físicas teste',
    'Condições de moradia teste',
    'Exposições a fatores ambientais teste',

    //história gineco-obstétrica (para mulheres)
    'Regularidade da menstruação teste',
    'Fluxo da menstruação teste',
    'Cólicas teste',
    'Gestação anteriores teste',
    'Partos teste',
    'Uso de contraceptivos teste',

    //investigação de sintomas em diferentes sistemas do organismo
    'Sintomas cardiovasculares teste',
    'Sintomas respiratórios teste',
    'Sintomas gastroinstestinais teste',
    'Sintomas nervosos teste'
);

//var_dump($anamnese);
