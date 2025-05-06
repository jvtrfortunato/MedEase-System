<?php

namespace App\Models;

require_once 'Paciente.php';
require_once 'Medico.php';
require_once 'Anamnese.php';
require_once 'ExameFisico.php';
require_once 'Exame.php';
require_once 'Prescricao.php';
require_once 'Atestado.php';
require_once 'HistoricoMedico.php';
require_once 'Internacao.php';
require_once 'Documentacao.php';
require_once 'Internacao.php';
require_once 'Documentacao.php';

class Prontuario {
    public function __construct(
        //Identificação
        private int $idProntuario,
        private string $dataCriacao,

        //Dados Paciente

        //Histórico médico e familiar
        private HistoricoMedico $historicoMedico, 

        //Anamnese
        private Anamnese $anamnese,

        //Exame Físico
        private ExameFisico $exameFisico, 

        //Diagnóstico
        private string $diagnosticoPresuntivo,
        private string $diagnosticoDiferencial,
        private string $diagnosticoDefinitivo,
        private string $cid10,

        //Exames Solicitados
        private array $examesSolicitados = [],

        //Prescrição Médica
        private Prescricao $prescricao,

        //Evolução do Quadro Clínico (observações de consultas sucessivas)
        private string $evolucao,

        //Exames de Imagem e Procedimentos
        private string $laudosExamesImagens,
        private string $procedimentosRealizados,

        //Registros de Internação e Cirurgias
        private Internacao $internacao,

        //Documentação e Consentimentos
        private Documentacao $documentacao,
        
        //Agendamentos e Histórico de Consultas
        private array $idProntuarios = [], //Isso deve estar aqui???

        //Observações Gerais e Notificações
        private string $doencasNotificacaoObrigatoria,
        private string $observacoesAdicionais,

        private int $idPaciente,
        private int $idMedico
    ){}
}
    

$prontuario = new Prontuario(
    //Identificação
    1,
    $paciente->getId(),
    $medico->getId(),
    '05/03/2025',

    //Informações Clínicas
    'Dor de cabeça',
    $anamnese,
    $exameFisico,
    'Enxaqueca',
    ['Enxaqueca'],
    $prescricao,

    //Dados Vitais e Exames
    '90,2 Kg',
    '1,85 m',
    'Hemograma completo',
    ['Hemograma completo'],
    ['Resultado teste'],
    ['Laudo teste'],

    //Outros
    'Masculino',
    'Paulo',
    'Maria',
    'Mariana',
    'Presidente Prudente - SP',
    'Desenvolvedor',
    'Pirapozinho - SP',
    'Nenhum encaminhamento',
    ['Histórico encaminhamento teste'],
    ['Antecedentes hospitalares teste'] //ARRUMAR TODOS DESSE AQUI
);

var_dump($prontuario);
