<?php
require_once '../controller/MedicoController.php';
require_once '../controller/SecretarioController.php';

$medicoController = new MedicoController();
$secretarioController = new SecretarioController();

$termoBusca = $_GET['termo'] ?? '';
$tipoAtual = $_GET['tipo'] ?? 'medicos';

if (!empty($termoBusca)) {
    $medicos = $medicoController->buscarPorNome($termoBusca);
    $secretarios = $secretarioController->buscarPorNome($termoBusca);
} else {
    $medicos = $medicoController->exibirDados();
    $secretarios = $secretarioController->exibirDados();
}
?>

<!-- O resto do seu HTML permanece o mesmo -->

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
            color: white; 
            border: none; 
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
                        <input type="text" name="termo" placeholder="Buscar Profissional (nome do profissional)" value="<?= htmlspecialchars($termoBusca) ?>">
                        <input type="hidden" name="tipo" id="inputTipo" value="<?= htmlspecialchars($tipoAtual) ?>">
                    </section>
                    <button type="submit" class="btnBusca">Buscar</button>
                </form>

                <div class="opcoes">
                    <button id="opcao-medico" onclick="mostrar('medicos')" class="opcao <?= $tipoAtual === 'medicos' ? 'ativo' : '' ?>">Médicos</button>
                    <button id="opcao-secretario" onclick="mostrar('secretarios')" class="opcao <?= $tipoAtual === 'secretarios' ? 'ativo' : '' ?>">Secretários</button>
                </div>
            </div>

            <section class="profissionais">
                <!--Lista Médicos-->
                <div id="lista-medicos" class="lista <?= $tipoAtual === 'medicos' ? '' : 'oculto' ?>">
                    <?php if (!empty($medicos)): ?>
                        <?php foreach ($medicos as $medico): ?>
                            <div class="dados">
                                <div class="nome">
                                    <p><?= htmlspecialchars($medico['nome']) ?> - <?= htmlspecialchars($medico['especialidade']) ?></p>
                                </div>
                                <div class="cpf">
                                    <p><?= htmlspecialchars($medico['cpf']) ?></p>
                                </div>
                                <a href="detalhes-medico.php?id_medico=<?= htmlspecialchars($medico['id_medico']) ?>" class="botaoVerde">
                                    Detalhes
                                </a>
                                <a href="editar-medico.php?id_medico=<?= htmlspecialchars($medico['id_medico']) ?>" class="botaoVerde">
                                    Editar
                                </a>
                                <a href="../routers/roteadorMedico.php?acao=excluirMedico&medico_id=<?= htmlspecialchars($medico['id_medico']) ?>" onclick="return confirm('Deseja excluir este profissional?');" class="botaoVermelho">
                                    Excluir
                                </a> 
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum médico cadastrado.</p>
                    <?php endif; ?>
                </div>  

                <!-- Lista Secretários -->
                <div id="lista-secretarios" class="lista <?= $tipoAtual === 'secretarios' ? '' : 'oculto' ?>">
                    <?php if (!empty($secretarios)): ?>
                        <?php foreach ($secretarios as $secretario): ?>
                            <div class="dados">
                                <div class="nome">
                                    <p><?= htmlspecialchars($secretario['nome']) ?></p>
                                </div>
                                <div class="cpf">
                                    <p><?= htmlspecialchars($secretario['cpf']) ?></p>
                                </div>
                                <a href="detalhes-secretario.php?id=<?= htmlspecialchars($secretario['id_secretario']) ?>" class="botaoVerde">
                                    Detalhes
                                </a>
                                <a href="editar-secretario.php?id=<?= htmlspecialchars($secretario['id_secretario']) ?>" class="botaoVerde">
                                    Editar
                                </a>
                                <a href="../routers/roteadorSecretario.php?acao=excluirSecretario&secretario_id=<?= htmlspecialchars($secretario['id_secretario']) ?>" onclick="return confirm('Deseja excluir este profissional?');" class="botaoVermelho">
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
        let tipoAtual = '<?= $tipoAtual ?>'; 

        function mostrar(tipo) {
            tipoAtual = tipo;
            // Atualiza o campo oculto do formulário
            document.getElementById('inputTipo').value = tipo;
            
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
            
            // Força o redesenho do layout para evitar problemas de renderização
            document.body.offsetHeight;
        }

        document.getElementById('botao-adicionar').addEventListener('click', function() {
            if (tipoAtual === 'medicos') {
                window.location.href = 'cadastrar-medico.php';
            } else {
                window.location.href = 'cadastrar-secretario.php';
            }
        });

        // Inicializa mostrando a aba correta
        document.addEventListener('DOMContentLoaded', function() {
            mostrar(tipoAtual);
        });
    </script>
</body>
</html>