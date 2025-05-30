<?php
require_once '../controller/MedicoController.php';
require_once '../controller/SecretarioController.php';

$medicoController = new MedicoController();
$medicos = $medicoController->exibirDados();

$secretarioController = new SecretarioController();
$secretarios = $secretarioController->exibirDados();

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Profissionais</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/gerenciar-profissionais.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>
    <main>
        <section class="conteudo-principal">

            <div class="busca-opcoes">
                
                <div class="busca">
                    <img src="../../assets/img/lupa.png" alt="Lupa de pesquisa">
                    <input type="text" placeholder="Buscar Profissional (nome do profissional)">
                </div>
                

                <div class="opcoes">
                    <button id="opcao-medico" onclick="mostrar('medicos')" class="opcao ativo">Médicos</button>
                    <button id="opcao-secretario" onclick="mostrar('secretarios')" class="opcao">Secretários</button>
                </div>

            </div>

            <section class="profissionais">
                
                <div class="legenda">
                    <p class="nome-legenda">Nome Completo</p>
                    <p>CPF</p>
                </div>
                
                <!--Lista Médicos-->
                <div id="lista-medicos" class="lista">
                    <?php if (!empty($medicos)): ?>
                        <?php foreach ($medicos as $medico): ?>
                           <!-- <pre><?php var_dump($medico); ?></pre> -->
                            <div class="dados">
                                <div class="nome">
                                    <p><?= htmlspecialchars($medico['nome']) ?></p>
                                </div>
                                <div class="cpf">
                                    <p><?= htmlspecialchars($medico['cpf']) ?></p>
                                </div>
                                <a href="detalhes-medico.php?id=<?= htmlspecialchars($medico['id_medico'] ?? '') ?>" class="detalhes">
                                    Ver detalhes
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum médico cadastrado.</p>
                    <?php endif; ?>
                </div>  


                <!-- Lista Secretários -->
                <div id="lista-secretarios" class="lista oculto">
                    <?php if (!empty($secretarios)): ?>
                        <?php foreach ($secretarios as $secretario): ?>
                           <!-- <pre><?php var_dump($secretario); ?></pre> -->
                            <div class="dados">
                                <div class="nome">
                                    <p><?= htmlspecialchars($secretario['nome']) ?></p>
                                </div>
                                <div class="cpf">
                                    <p><?= htmlspecialchars($secretario['cpf']) ?></p>
                                </div>
                                <a href="detalhes-secretario.php?id=<?= htmlspecialchars($secretario['id_secretario'] ?? '') ?>" class="detalhes">
                                    Ver detalhes
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum secretário cadastrado.</p>
                    <?php endif; ?>
                </div>

            </section>

        </section>
        <section class="botao">
            <button class="voltar" onclick="history.back()">Voltar</button>
            <button id="botao-adicionar" class="adicionar">Adicionar Profissional</button>
        </section>
    </main>
    <footer></footer>

    <script>
        let tipoAtual = 'medicos'; 

        function mostrar(tipo){
            tipoAtual = tipo;
            // Esconde ambas as listas
            document.getElementById('lista-medicos').classList.add('oculto');
            document.getElementById('lista-secretarios').classList.add('oculto');

            // Remove o destaque dos botões
            document.getElementById('opcao-medico').classList.remove('ativo');
            document.getElementById('opcao-secretario').classList.remove('ativo');

            if (tipo === 'medicos') {
                document.getElementById('lista-medicos').classList.remove('oculto');
                document.getElementById('opcao-medico').classList.add('ativo');
            } else {
                document.getElementById('lista-secretarios').classList.remove('oculto');
                document.getElementById('opcao-secretario').classList.add('ativo');
            }            
        }

        document.getElementById('botao-adicionar').addEventListener('click', function() {
            if (tipoAtual === 'medicos') {
                window.location.href = 'cadastrar-medico.php';
            } else {
                window.location.href = 'cadastrar-secretario.php';
            }
        });
    </script>
</body>
</html>
