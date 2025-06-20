<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário MedEase</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

    <link rel="stylesheet" href="../../assets/css/calendario-joao.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
</head>
<body>

    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>

    <div class="container">

        <h2>Agenda</h2>

        <span id="msg"></span>

        <div id='calendar'></div>

        <button type="button" class="botaoVermelho" id="voltarPagina" onClick="window.history.back()">Voltar</button>

    </div>

    <!-- Modal Visualizar -->
    <div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h1 class="modal-title fs-5" id="visualizarModalLabel">Descrição da Consulta</h1>

                    <h1 class="modal-title fs-5" id="editarModalLabel" style="display: none;">Editar Consulta</h1>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <span id="msgViewEvento"></span>

                    <div id="visualizarConsulta">

                        <dl class="row">

                            <!-- Oculto: ID da consulta -->
                            <dd id="visualizar_id" style="display: none;"></dd>

                            <dt class="col-sm-3">Motivo:</dt>
                            <dd class="col-sm-9" id="visualizar_title"></dd>

                            <dt class="col-sm-3">Paciente:</dt>
                            <dd class="col-sm-9" id="visualizar_nome_paciente"></dd>

                            <dt class="col-sm-3">Médico:</dt>
                            <dd class="col-sm-9" id="visualizar_nome_medico"></dd>

                            <dt class="col-sm-3">Início:</dt>
                            <dd class="col-sm-9" id="visualizar_start"></dd>

                            <dt class="col-sm-3">Fim:</dt>
                            <dd class="col-sm-9" id="visualizar_end"></dd>

                            <dt class="col-sm-3">Status:</dt>
                            <dd class="col-sm-9" id="visualizar_status"></dd>

                        </dl>

                        <button type="button" class="btn btn-warning" id="btnViewEditConsulta">Editar</button>

                        <button type="button" class="btn btn-danger" id="btnApagarConsulta">Apagar</button>
                    
                    </div>

                    <div id="editarConsulta" style="display: none;">

                        <span id="msgEditConsulta"></span>

                        <form method="POST" id="formEditConsulta">

                            <input type="hidden" name="edit_id" id="edit_id">

                            <div class="row mb-3">
                                <label for="edit_title" class="col-sm-2 col-form-label">Motivo</label>
                                <div class="col-sm-10">
                                    <input type="text" name="edit_title" class="form-control" id="edit_title" placeholder="Digite o motivo">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="edit_nome_paciente" class="col-sm-2 col-form-label">Paciente</label>
                                <div class="col-sm-10">
                                    <select name="edit_nome_paciente" class="form-control" id="edit_nome_paciente">
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="edit_nome_medico" class="col-sm-2 col-form-label">Médico</label>
                                <div class="col-sm-10">
                                    <select name="edit_nome_medico" class="form-control" id="edit_nome_medico"> 
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="edit_start" class="col-sm-2 col-form-label">Início</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" name="edit_start" class="form-control" id="edit_start">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="edit_end" class="col-sm-2 col-form-label">Fim</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" name="edit_end" class="form-control" id="edit_end">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="edit_status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="edit_status" class="form-control" id="edit_status">
                                        <option value="">Selecione</option>
                                        <option value="Agendada">Agendada</option>
                                        <option value="Realizada">Realizada</option>
                                        <option value="Cancelada">Cancelada</option>
                                    </select>
                                </div>
                            </div>

                            <button type="button" name="btnViewConsulta" class="btn btn-primary" id="btnViewConsulta">Cancelar</button>

                            <button type="submit" name="btnEditConsulta" class="btn btn-warning" id="btnEditConsulta">Salvar</button>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cadastrar -->
    <div class="modal fade" id="cadastrarModal" tabindex="-1" aria-labelledby="cadastrarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cadastrarModalLabel">Nova consulta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <span id="msgCadConsulta"></span>

                    <form method="POST" id="formCadConsulta">

                        <div class="row mb-3">
                            <label for="cad_title" class="col-sm-2 col-form-label">Motivo</label>
                            <div class="col-sm-10">
                                <input type="text" name="cad_title" class="form-control" id="cad_title" placeholder="Digite o motivo">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cad_nome_paciente" class="col-sm-2 col-form-label">Paciente</label>
                            <div class="col-sm-10">
                                <select name="cad_nome_paciente" class="form-control" id="cad_nome_paciente">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cad_nome_medico" class="col-sm-2 col-form-label">Médico</label>
                            <div class="col-sm-10">
                                <select name="cad_nome_medico" class="form-control" id="cad_nome_medico">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cad_start" class="col-sm-2 col-form-label">Início</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="cad_start" class="form-control" id="cad_start">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cad_end" class="col-sm-2 col-form-label">Fim</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="cad_end" class="form-control" id="cad_end">
                            </div>
                        </div>

                        <input type="hidden" name="cad_status" class="form-control" id="cad_status" value="Agendada">

                        <button type="submit" name="btnCadConsulta" class="btn btn-success" id="btnCadConsulta">Cadastrar</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src='../../assets/script/calendario-joao.min.js'></script>
    <script src="../../assets/script/bootstrap5/index.global.min.js"></script>
    <script src='../../assets/script/core/locales-all.global.min.js'></script>
    <script>
        const tipoUsuario = "<?php echo $_SESSION['usuario_tipo']; ?>";
        const medicoId = "<?php echo $_SESSION['medico_id'] ?? ''; ?>";
    </script>
    <script src='../../assets/script/calendario-joao-custom.js'></script>
</body>
</html>