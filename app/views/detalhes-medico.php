<?php
require_once '../controller/MedicoController.php';

// Debug temporário:
// echo "<pre>";
// var_dump($_GET);
// echo "</pre>";

if (!isset($_GET['id_medico'])) {
    echo "ID do médico não fornecido.";
    exit;
}

$idMedico = $_GET['id_medico'];
$controller = new MedicoController();
$medico = $controller->dadosMedico($idMedico);

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
    <link rel="stylesheet" href="../../assets/css/detalhes-medico.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">Sair</a>
    </header>

    <main>
        <section class="conteudo-principal">
            <h1>Dados Gerais</h1>
            <section class="dados-gerais-endereco">
                <div class="linha">
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <p class="label">CPF</p>
                            <div class="input"><p><?= htmlspecialchars($medico->getCpf()) ?></p></div>
                        </div>
                        <div class="label-input">
                            <p class="label">CRM</p>
                            <div class="input"><p><?= htmlspecialchars($medico->getCRM()) ?></p></div>
                        </div>
                    </div>
                    <div class="label-input">
                        <p class="label">Especialidade</p>
                        <div class="input"><p><?= htmlspecialchars($medico->getEspecialidade()) ?></p></div>
                    </div>
                </div>

                <div class="linha">         
                    <div class="label-input">
                        <p class="label">Nome</p>
                        <div class="input"><p><?= htmlspecialchars($medico->getNome()) ?></p></div>
                    </div>          
                    <div class="linha-pequenos">           
                        <div class="label-input">
                            <p class="label">Data de nascimento</p>
                            <div class="input"><p><?= htmlspecialchars(date('d/m/Y', strtotime($medico->getDataNascimento()))) ?></p></div>
                        </div>                        
                        <div class="label-input">
                            <p class="label">Sexo</p>
                            <div class="input"><p><?= htmlspecialchars($medico->getSexo()) ?></p></div>
                        </div>
                    </div>
                </div>
                
                <div class="linha">
                    <div class="label-input">
                        <p class="label">Telefone</p>
                        <div class="input"><p><?= htmlspecialchars($medico->getTelefone()) ?></p></div>        
                    </div>

                    <div class="label-input">
                        <p class="label">Email</p>
                        <div class="input"><p><?= htmlspecialchars($medico->getEmail()) ?></p></div>
                    </div>
                </div>
            </section>

            <h1 class="endereco">Endereço</h1>
            <section class="dados-gerais-endereco">
                <div class="linha">
                    <div class="label-input">
                        <p class="label">Rua</p>
                        <div class="input"><p><?= htmlspecialchars($medico->getEndereco()->getRua()) ?></p></div>
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <p class="label">Número</p>
                            <div class="input"><p><?= htmlspecialchars($medico->getEndereco()->getNumero()) ?></p></div>   
                        </div>
                        <div class="label-input">
                            <p class="label">Bairro</p>
                            <div class="input"><p><?= htmlspecialchars($medico->getEndereco()->getBairro()) ?></p></div>   
                        </div>
                    </div>
                </div>

                <div class="linha">
                    <div class="label-input">
                        <p class="label">Cidade</p>
                        <div class="input"><p><?= htmlspecialchars($medico->getEndereco()->getCidade()) ?></p></div>
                    </div>
                    <div class="linha-pequenos">
                        <div class="label-input">
                            <p class="label">Estado (UF)</p>
                            <div class="input"><p><?= htmlspecialchars($medico->getEndereco()->getEstado()) ?></p></div>
                        </div>
                        <div class="label-input">
                            <p class="label">CEP</p>
                            <div class="input"><p><?= htmlspecialchars($medico->getEndereco()->getCEP()) ?></p></div>
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
