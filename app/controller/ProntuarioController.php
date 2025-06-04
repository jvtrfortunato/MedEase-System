<?php
require_once '../config/Database.php';
require_once '../model/Consulta.php';
require_once '../model/Endereco.php';
require_once '../model/Paciente.php';
require_once '../model/Prontuario.php';
require_once '../model/HistoricoMedico.php';
require_once '../model/Anamnese.php';
require_once '../model/ExameFisico.php';
require_once '../model/Prescricao.php';
require_once '../model/Internacao.php';
require_once '../model/Documentacao.php';
require_once '../model/Atestado.php';

class ProntuarioController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function salvarProntuario() {
        $prontuario = new Prontuario(
            idProntuario: 0,
            dataCriacao: $_SESSION['data_hoje'],
            historicoMedico: new HistoricoMedico(
                '',
                '',
                '',
                '',
                '',
                null
            ),
            anamnese: new Anamnese(
                $_SESSION['consulta_motivo'],
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                null
            ),
            exameFisico: $exameFisico = new ExameFisico(
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                null
            ),
            diagnosticoPresuntivo: '',
            diagnosticoDiferencial: '',
            diagnosticoDefinitivo: '',
            cid10: '',
            examesSolicitados: [],
            prescricao: new Prescricao(
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                0,
                '',
                '',
                null
            ),
            evolucao: '',
            laudosExamesImagens: '',
            procedimentosRealizados: '',
            internacao: new Internacao(
                '',
                '',
                '',
                '',
                null
            ),
            documentacao: new Documentacao(
                null,
                '',
                $atestado = new Atestado(null, '', '', null),
                '',
                null
            ),
            historicoProntuarios: [],
            doencasNotificacaoObrigatoria: '',
            observacoesAdicionais: '',
            idPaciente: $_SESSION['paciente_id'],
            idMedico: $_SESSION['medico_id']
        );
            var_dump('entrouMetodo');    
    }
}
