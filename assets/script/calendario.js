document.addEventListener('DOMContentLoaded', function () {
    // Verifica se há necessidade de recarregar
    if (localStorage.getItem("forceReload") === "true") {
        localStorage.removeItem("forceReload");
        location.reload();
        return;
    }

    const calendarEl = document.getElementById('calendar');
    const agendamentos = [];

    for (let i = 0; i < localStorage.length; i++) {
        const data = localStorage.key(i);
        const valor = localStorage.getItem(data);

        try {
            const horarios = JSON.parse(valor);
            if (Array.isArray(horarios)) {
                horarios.forEach(hora => {
                    agendamentos.push({
                        title: 'Agendado: ' + hora,
                        start: data,
                        color: '#ff4d4d'
                    });
                });
            } else {
                agendamentos.push({
                    title: 'Agendado: ' + valor,
                    start: data,
                    color: '#ff4d4d'
                });
            }
        } catch (e) {
            agendamentos.push({
                title: 'Agendado: ' + valor,
                start: data,
                color: '#ff4d4d'
            });
        }
    }

    // Obter o modo da URL (agendar ou consultas)
    const urlParams = new URLSearchParams(window.location.search);
    const modo = urlParams.get("modo");

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
        events: agendamentos,
        dateClick: function (info) {
            if (modo === "agendar") {
                window.location.href = '../../app/views/agendar-consultas.php?modo=agendar&data=' + info.dateStr;
            } else {
                window.location.href = '../../app/views/consultas-agendadas.php?modo=consultas&data=' + info.dateStr;
            }
        }
    });

    calendar.render();
});

