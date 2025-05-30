<?php
require_once '../controller/SecretarioController.php';

//  echo "<pre>";
//  var_dump($_GET);
//  echo "</pre>";

if (!isset($_GET['id'])) {
    echo "ID do secretário não fornecido.";
    exit;
}

$id = $_GET['id'];
$controller = new SecretarioController();
$secretario = $controller->dadosSecretario($id);

if (!$secretario) {
    echo "Secretário não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Secretário</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/cadastrar-secretario.css">
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
                            <p><?= htmlspecialchars($secretario->getCpf()) ?></p>
                        </div>
                    </div>
                </div>

                <div class="linha">         
                    <div class="label-input">
                        <label>Nome completo</label>
                        <p><?= htmlspecialchars($secretario->getNome()) ?></p>
                    </div>          
                    <div class="linha-pequenos">           
                        <div class="label-input">
                            <label>Data de Nascimento</label>
                            <p><?= htmlspecialchars(date('d/m/Y', strtotime($secretario->getDataNascimento()))) ?></p>
                        </div>                        
                        <div class="label-input">
                            <label>Sexo</label>
                            <p><?= htmlspecialchars($secretario->getSexo()) ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="linha">
                    <div class="label-input">
                        <label>Telefone</label>
                        <p><?= htmlspecialchars($secretario->getTelefone()) ?></p>
                    </div>

                    <div class="label-input">
                        <label>Email</label>
                        <p><?= htmlspecialchars($secretario->getEmail()) ?></p>
                    </div>
                </div>
            </section>

            <h1 class="endereco">Endereço</h1>
            <section class="dados-gerais-endereco">
                <div class="linha">
                    <div class="label-input">
                        <label>Rua</label>
                        <p><?= htmlspecialchars($secretario->getEndereco()->getRua()) ?></p>
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label>Número</label>
                            <p><?= htmlspecialchars($secretario->getEndereco()->getNumero()) ?></p>
                        </div>
                        <div class="label-input">
                            <label>Bairro</label>
                            <p><?= htmlspecialchars($secretario->getEndereco()->getBairro()) ?></p>
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <label>Cidade</label>
                        <p><?= htmlspecialchars($secretario->getEndereco()->getCidade()) ?></p>
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <label>Estado</label>
                            <p><?= htmlspecialchars($secretario->getEndereco()->getEstado()) ?></p>
                        </div>
                        <div class="label-input">
                            <label>CEP</label>
                            <p><?= htmlspecialchars($secretario->getEndereco()->getCEP()) ?></p>
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
