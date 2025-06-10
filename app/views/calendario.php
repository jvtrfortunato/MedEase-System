<!-- <?php
require_once '../controller/ConsultaController.php';

$id_medico = $_GET['id_medico'] ?? null;

$consultaController = new ConsultaController();

if ($id_medico) {
    $consultas = $consultaController->buscarConsultasPorMedico($id_medico);
} else {
    // Admin visualiza todas
    $consultas = $consultaController->buscarTodasConsultas();
}

$consultasJson = json_encode($consultas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Calendário</title>
    <link rel="stylesheet" href="../../assets/css/header.css" />
    <link rel="stylesheet" href="../../assets/css/agendar-consulta.css" />
    <link rel="stylesheet" href="../../assets/css/calendario.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js" defer></script>
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>
        <a href="">sair</a>
    </header>

    <main>
        <div id="calendar"></div>
        <div class="caixa-botao-voltar">
            <a href="#" class="botao-voltar">Voltar</a>
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Recarrega a página se necessário
        if (localStorage.getItem("forceReload") === "true") {
            localStorage.removeItem("forceReload");
            location.reload();
            return;
        }

        const calendarEl = document.getElementById('calendar');
        const consultasBanco = <?php echo $consultasJson; ?>;

        // Recupera o id_medico da URL
        const urlParams = new URLSearchParams(window.location.search);
        const id_medico = urlParams.get("id_medico");
        const modo = urlParams.get("modo");

        // Consultas vindas do PHP (banco de dados)
        const eventosBanco = consultasBanco.map(consulta => ({
            title: 'Consulta - ' + consulta.hora,
            start: consulta.data,
            color: '#ff4d4d'
        }));

        // Consultas vindas do localStorage (filtradas por id_medico)
        const eventosLocal = [];
        for (let i = 0; i < localStorage.length; i++) {
            const data = localStorage.key(i);
            const valor = localStorage.getItem(data);

            try {
                const dados = JSON.parse(valor);
                if (dados.id_medico == id_medico) {
                    const horarios = dados.horarios;
                    if (Array.isArray(horarios)) {
                        horarios.forEach(hora => {
                            eventosLocal.push({
                                title: 'Agendado: ' + hora,
                                start: data,
                                color: '#ff4d4d'
                            });
                        });
                    }
                }
            } catch (e) {
                // Ignora entradas que não são JSON válidos
            }
        }

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            buttonText: {
                today: 'Hoje',
                month: 'Mês',
                week: 'Semana',
                day: 'Dia',
                list: 'Lista'
            },
            events: [...eventosBanco, ...eventosLocal],
            dateClick: function (info) {
                if (modo === "agendar") {
                    window.location.href = `../../app/views/agendar-consultas.php?modo=agendar&id_medico=${id_medico}&data=${info.dateStr}`;
                } else {
                    window.location.href = `../../app/views/consultas-agendadas.php?modo=consultas&id_medico=${id_medico}&data=${info.dateStr}`;
                }
            }
        });

        calendar.render();
    });
    </script>
</body>
</html> -->
