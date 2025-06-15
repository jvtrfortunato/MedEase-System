<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Paciente</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/reset.css ">
    <link rel="stylesheet" href="../../assets/css/detalhes-paciente.css ">
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
        <section class="conteudo-principal">
            <h1>Dados Gerais</h1>
            <section class="dados-gerais-endereco">
                
                <div class="linha">
                    <div class="label-input">
                        <h2>Nome completo</h2>
                        <div class="input">
                            <p><?= htmlspecialchars($paciente->getNome()) ?></p> 
                        </div>
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <h2>Data de nascimento</h2>
                            <div class="input">
                                <p><?= htmlspecialchars($paciente->getDataNascimento()) ?></p> 
                            </div>
                        </div>
                        <div class="label-input">
                            <h2>Sexo</h2>
                            <div class="input">
                                <p><?= htmlspecialchars($paciente->getSexo()) ?></p> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <h2>Estado civil</h2>
                        <div class="input">
                            <p><?= htmlspecialchars($paciente->getEstadoCivil()) ?></p> 
                        </div>
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <h2>CPF</h2>
                            <div class="input">
                                <p><?= htmlspecialchars($paciente->getCpf()) ?></p> 
                            </div>
                        </div>
                        <div class="label-input">
                            <h2>RG</h2>
                            <div class="input">
                                <p><?= htmlspecialchars($paciente->getRg()) ?></p> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <h2>Telefone</h2>
                        <div class="input">
                            <p><?= htmlspecialchars($paciente->getTelefone()) ?></p> 
                        </div>
                    </div>
                    <div class="label-input">
                        <h2>Email</h2>
                        <div class="input">
                            <p><?= htmlspecialchars($paciente->getEmail()) ?></p> 
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <h2>Nome do responsável</h2>
                        <div class="input">
                            <p><?= htmlspecialchars($paciente->getNomeResponsavel()) ?></p> 
                        </div>
                    </div>
                    <div class="label-input">
                        <h2>Cartão Nacional de Saúde (CNS)</h2>
                        <div class="input">
                            <p><?= htmlspecialchars($paciente->getCns()) ?></p> 
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <h2>Convênio</h2>
                        <div class="input">
                            <p><?= htmlspecialchars($paciente->getConvenio()) ?></p> 
                        </div>
                    </div>
                    <div class="label-input">
                        <h2>Número do Plano de Saúde</h2>
                        <div class="input">
                            <p><?= htmlspecialchars($paciente->getPlanoSaude()) ?></p> 
                        </div>
                    </div>
                </div>

            </section>

            <h1 class="endereco">Endereço</h1>
            <div class="dados-gerais-endereco">

                <div class="linha">
                    <div class="label-input">
                        <h2>Rua</h2>
                        <div class="input">
                            <p><?= htmlspecialchars($endereco->getRua()) ?></p>
                        </div>
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <h2>Número</h2>
                            <div class="input">
                                <p><?= htmlspecialchars($endereco->getNumero()) ?></p> 
                            </div>
                        </div>
                        <div class="label-input">
                            <h2>Bairro</h2>
                            <div class="input">
                                <p><?= htmlspecialchars($endereco->getBairro()) ?></p> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <h2>Cidade</h2>
                        <div class="input">
                            <p><?= htmlspecialchars($endereco->getCidade()) ?></p> 
                        </div>
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <h2>Estado (UF)</h2>
                            <div class="input">
                                <p><?= htmlspecialchars($endereco->getEstado()) ?></p> 
                            </div>
                        </div>
                        <div class="label-input">
                            <h2>CEP</h2>
                            <div class="input">
                                <p><?= htmlspecialchars($endereco->getCep()) ?></p> 
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
        <section class="botoes">
            <button id="voltarPagina" class="voltar" type="button">Voltar</button>
        </section>
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