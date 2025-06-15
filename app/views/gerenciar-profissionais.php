<?php
require_once '../controller/MedicoController.php';
require_once '../controller/SecretarioController.php';

$medicoController = new MedicoController();
$secretarioController = new SecretarioController();

$termoBusca = $_GET['termo'] ?? '';

if (!empty($termoBusca)) {
    $medicos = $medicoController->buscarPorNome($termoBusca);
    $secretarios = $secretarioController->buscarPorNome($termoBusca);
} else {
    $medicos = $medicoController->exibirDados();
    $secretarios = $secretarioController->exibirDados();
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Profissionais</title>
    <style>
        .btnBusca {
            padding: 6px 12px;
            margin-left: 6px; 
            background-color: #3498db; 
            color: white; border: none; 
            border-radius: 4px; 
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/gerenciar-profissionais.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="login.php">sair</a>
    </header>
    <main>
        <section class="conteudo-principal">

            <div class="busca-opcoes">

                <form action="" method="GET" style="display: flex;">
                    <section class="busca" style="width: 300px;">
                        <img src="../../assets/img/lupa.png" alt="Lupa de pesquisa">
                        <input type="text" name="termo" placeholder="Buscar Profissional (nome do profissional)" value="<?= htmlspecialchars($_GET['termo'] ?? '') ?>">
                    </section>
                    <button type="submit" class="btnBusca">Buscar</button>
                </form>

                <div class="opcoes">
                    <button id="opcao-medico" onclick="mostrar('medicos')" class="opcao ativo">Médicos</button>
                    <button id="opcao-secretario" onclick="mostrar('secretarios')" class="opcao">Secretários</button>
                </div>

            </div>

            <section class="profissionais">
         
                <!--Lista Médicos-->
                <div id="lista-medicos" class="lista">
                    <?php if (!empty($medicos)): ?>
                        <?php foreach ($medicos as $medico): ?>
                           <!-- <pre><?php var_dump($medico); ?></pre> -->
                            <div class="dados">
                                <div class="nome">
                                    <p><?= htmlspecialchars($medico['nome']) ?> - <?= htmlspecialchars($medico['especialidade']) ?></p>
                                </div>
                                <div class="cpf">
                                    <p><?= htmlspecialchars($medico['cpf']) ?></p>
                                </div>
                                <a href="detalhes-medico.php?id_medico=<?= htmlspecialchars($medico['id_medico'] ?? '') ?>" class="botaoVerde">
                                    Detalhes
                                </a>
                                <a href="editar-medico.php?id_medico=<?= htmlspecialchars($medico['id_medico'] ?? '') ?>" class="botaoVerde">
                                    Editar
                                </a>
                                <a href="../routers/roteadorMedico.php?acao=excluirMedico&medico_id=<?= htmlspecialchars($medico['id_medico'] ?? '') ?>" onclick="return confirm('Deseja excluir este profissional?');" class="botaoVermelho">
                                    Excluir
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
                                <a href="detalhes-secretario.php?id=<?= htmlspecialchars($secretario['id_secretario'] ?? '') ?>" class="botaoVerde">
                                    Detalhes
                                </a>
                                <a href="editar-secretario.php?id=<?= htmlspecialchars($secretario['id_secretario'] ?? '') ?>" class="botaoVerde">
                                    Editar
                                </a>
                                <a href="../routers/roteadorSecretario.php?acao=excluirSecretario&secretario_id=<?= htmlspecialchars($secretario['id_secretario'] ?? '') ?>" onclick="return confirm('Deseja excluir este profissional?');" class="botaoVermelho">
                                    Excluir
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
            <button class="botaoVermelho" onclick="window.location.href = 'home-administrador.php';">Voltar</button>
            <button id="botao-adicionar" class="botaoVerde">Cadastrar Profissional</button>
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
