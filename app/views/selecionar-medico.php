<?php
require_once '../controller/MedicoController.php';

$medicoController = new MedicoController();
$medicos = $medicoController->exibirDados();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Médico</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/selecionar-medico.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>

    <main>
        <section class="conteudo-principal">
            <form action="">
                <label for="medico">Selecione o Médico</label>
                <select id="medico" name="medico">
                    <?php if (!empty($medicos)): ?>
                        <?php foreach ($medicos as $medico): ?>
                            <?php var_dump($medico); ?>
                                <option value=""><?= htmlspecialchars($medico['nome']) ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum médico cadastrado.</p>
                    <?php endif; ?>
                </select>
                <div class="botoes">
                    <button class="voltar" type="button">Voltar</button>
                    <button class="salvar" type="submit">Confirmar</button>
                </div>
            </form>
        </section>
    </main>

    <footer></footer>
</body>
</html>