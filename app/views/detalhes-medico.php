<?php
require_once '../controller/MedicoController.php';

// Debug temporário:
// echo "<pre>";
// var_dump($_GET);
// echo "</pre>";

if (!isset($_GET['id'])) {
    echo "ID do médico não fornecido.";
    exit;
}

$id = $_GET['id'];
$controller = new MedicoController();
$medico = $controller->dadosMedico($id);

if (!$medico) {
    echo "Médico não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Médico</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/cadastrar-medico.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">Sair</a>
    </header>

    <main>
        <section class="conteudo-principal">
            <h1>Dados Gerais</h1>
            <section class="dados-gerais-endereco">
                <div class="linha">
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label>CPF</label>
                            <p><?= htmlspecialchars($medico->getCpf()) ?></p>
                        </div>
                        <div class="label-input">
                            <label>CRM</label>
                            <p><?= htmlspecialchars($medico->getCRM()) ?></p>
                        </div>
                    </div>
                    <div class="label-input">
                        <label>Especialidade</label>
                        <p><?= htmlspecialchars($medico->getEspecialidade()) ?></p>
                    </div>
                </div>

                <div class="linha">         
                    <div class="label-input">
                        <label>Nome completo</label>
                        <p><?= htmlspecialchars($medico->getNome()) ?></p>
                    </div>          
                    <div class="linha-pequenos">           
                        <div class="label-input">
                            <label>Data de Nascimento</label>
                            <p><?= htmlspecialchars(date('d/m/Y', strtotime($medico->getDataNascimento()))) ?></p>
                        </div>                        
                        <div class="label-input">
                            <label>Sexo</label>
                            <p><?= htmlspecialchars($medico->getSexo()) ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="linha">
                    <div class="label-input">
                        <label>Telefone</label>
                        <p><?= htmlspecialchars($medico->getTelefone()) ?></p>
                    </div>

                    <div class="label-input">
                        <label>Email</label>
                        <p><?= htmlspecialchars($medico->getEmail()) ?></p>
                    </div>
                </div>
            </section>

            <h1 class="endereco">Endereço</h1>
            <section class="dados-gerais-endereco">
                <div class="linha">
                    <div class="label-input">
                        <label>Rua</label>
                        <p><?= htmlspecialchars($medico->getEndereco()->getRua()) ?></p>
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label>Número</label>
                            <p><?= htmlspecialchars($medico->getEndereco()->getNumero()) ?></p>
                        </div>
                        <div class="label-input">
                            <label>Bairro</label>
                            <p><?= htmlspecialchars($medico->getEndereco()->getBairro()) ?></p>
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <label>Cidade</label>
                        <p><?= htmlspecialchars($medico->getEndereco()->getCidade()) ?></p>
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label>Estado</label>
                            <p><?= htmlspecialchars($medico->getEndereco()->getEstado()) ?></p>
                        </div>
                        <div class="label-input">
                            <label>CEP</label>
                            <p><?= htmlspecialchars($medico->getEndereco()->getCEP()) ?></p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="botoes">
                <button class="voltar" onclick="history.back()">Voltar</button>
            </section>
        </section>
    </main>
</body>
</html>
