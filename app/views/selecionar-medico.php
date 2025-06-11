<?php
require_once '../controller/MedicoController.php';

$medicoController = new MedicoController();
$medicos = $medicoController->exibirDados();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Selecionar Médico</title>
    <link rel="stylesheet" href="../../assets/css/header.css" />
    <link rel="stylesheet" href="../../assets/css/selecionar-medico.css" />
</head>

<body>
    <form action="">
        <label for="medico">Selecione o Médico</label>
        <select id="medico" name="medico" required>
            <option value="" disabled selected>-- Escolha um médico --</option>
            <?php foreach ($medicos as $medico): ?>
                <option value="<?= htmlspecialchars($medico['id_medico']) ?>">
                    <?= htmlspecialchars($medico['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button id="btnConfirmar" type="submit">Confirmar</button>
    </form>

    <!-- <script>
      document.getElementById("btnConfirmar").addEventListener("click", function(event) {
        event.preventDefault();
        const idMedico = document.getElementById("medico").value;

        if (idMedico) {
          window.location.href = "calendario.php?id_medico=" + encodeURIComponent(idMedico);
        } else {
          alert("Selecione um médico.");
        }
      });
    </script> -->
</body>
</html>
