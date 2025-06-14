<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Paciente</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/reset.css ">
    <link rel="stylesheet" href="../../assets/css/editar-paciente.css ">
</head>
<body>
    <?php
    require_once '../controller/PacienteController.php';

    $controller = new PacienteController();

    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo "ID do paciente não fornecido.";
        exit;
    }

    $paciente = $controller->buscarPacienteCompleto((int)$id);

    if (!$paciente) {
        echo "Paciente não encontrado.";
        exit;
    }

    $endereco = $paciente->getEndereco();
    ?>
    
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    
    <main>   
        <form class="conteudo-principal" action="../routers/roteadorPaciente.php" method="post">
            <input type="hidden" name="acao" value="atualizarPaciente">
            <input type="hidden" name="idPaciente" value="<?= htmlspecialchars($paciente->getIdPaciente()) ?>">
            <h1>Editar Paciente</h1>
            <h2>Dados Gerais</h2>
            <section class="dados-gerais-endereco">
                
                <div class="linha">
                    <div class="label-input">
                        <label>Nome completo</label>
                        <input class="input" name="nome" value="<?= htmlspecialchars($paciente->getNome()) ?>">      
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label>Data de nascimento</label>
                            <input class="input" name="dataNascimento" value="<?= htmlspecialchars($paciente->getDataNascimento()) ?>"> 

                        </div>
                        <div class="label-input">
                            <label>Sexo</label>
                            <input class="input" name="sexo" value="<?= htmlspecialchars($paciente->getSexo()) ?>">
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <label>Estado civil</label>
                        <input class="input" name="estadoCivil" value="<?= htmlspecialchars($paciente->getEstadoCivil()) ?>">
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label>CPF</label>
                            <input class="input" name="cpf" value="<?= htmlspecialchars($paciente->getCpf()) ?>">
                        </div>
                        <div class="label-input">
                            <label>RG</label>
                            <input class="input" name="rg" value="<?= htmlspecialchars($paciente->getRg()) ?>">
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <label>Telefone</label>
                        <input class="input" name="telefone" value="<?= htmlspecialchars($paciente->getTelefone()) ?>">
                    </div>
                    <div class="label-input">
                        <label>Email</label>
                        <input class="input" name="email" value="<?= htmlspecialchars($paciente->getEmail()) ?>">
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <label>Nome do responsável</label>
                        <input class="input" name="nomeResponsavel" value="<?= htmlspecialchars($paciente->getNomeResponsavel()) ?>"> 
                    </div>
                    <div class="label-input">
                        <label>Cartão Nacional de Saúde (CNS)</label>
                        <input class="input" name="cns" value="<?= htmlspecialchars($paciente->getCns()) ?>">
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <label>Convênio</label>
                        <input class="input" name="convenio" value="<?= htmlspecialchars($paciente->getConvenio()) ?>">
                    </div>
                    <div class="label-input">
                        <label>Número do Plano de Saúde</label>
                        <input class="input" name="numPlanoSaude" value="<?= htmlspecialchars($paciente->getPlanoSaude()) ?>">
                    </div>
                </div>

            </section>

            <h2 class="endereco">Endereço</h2>
            <div class="dados-gerais-endereco">

                <div class="linha">
                    <div class="label-input">
                        <label>Rua</label>
                        <input class="input" name="rua" value="<?= htmlspecialchars($endereco->getRua()) ?>">
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label>Número</label>
                            <input class="input" name="numero" value="<?= htmlspecialchars($endereco->getNumero()) ?>">
                        </div>
                        <div class="label-input">
                            <label>Bairro</label>
                            <input class="input" name="bairro" value="<?= htmlspecialchars($endereco->getBairro()) ?>">
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <label>Cidade</label>
                        <input class="input" name="cidade" value="<?= htmlspecialchars($endereco->getCidade()) ?>">
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label>Estado (UF)</label>
                            <input class="input" name="estado" value="<?= htmlspecialchars($endereco->getEstado()) ?>">
                        </div>
                        <div class="label-input">
                            <label>CEP</label>
                            <input class="input" name="cep" value="<?= htmlspecialchars($endereco->getCep()) ?>">
                        </div>
                    </div>
                </div>

            </div>

            <section class="botoes">
                <button id="voltarPagina" class="voltar" type="button">Voltar</button>
                <button class="salvar" type="submit">Salvar</button>
            </section>
        </form>
        
    </main>
    
    <footer></footer>
    
    <script>
        // Evento para o botão "Voltar" (se existir)
        if (voltarPagina) {
            voltarPagina.addEventListener("click", () => {
                if (window.history.length > 1) {
                    window.history.back(); // volta à página anterior no histórico
                } else {
                    // Fallback: redireciona manualmente caso não haja histórico
                    if ($tipoUsuario === 'administrador') {
                        window.location.href = "home-administrador.php";
                    }
                    else {
                        window.location.href = "home-secretario.php";
                    }
                }
            });
        }
    </script>
</body>
</html>