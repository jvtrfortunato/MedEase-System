document.addEventListener('DOMContentLoaded', function() {

    // Verifica se precisa forçar recarregamento (por exemplo, após desmarcar um horário)
    if (localStorage.getItem("forceReload") === "true") {
        localStorage.removeItem("forceReload");
        location.reload();
        return; // impede o restante do código de ser executado
    }

    // Seleciona o elemento HTML onde o calendário será renderizado
    const calendarEl = document.getElementById('calendar');

    // Cria um array para armazenar os agendamentos que serão exibidos no calendário
    const agendamentos = [];

    // Percorre todos os itens armazenados no localStorage
    for (let i = 0; i < localStorage.length; i++) {
        const data = localStorage.key(i);
        const valor = localStorage.getItem(data);

        try {
            // Tenta parsear como array (caso tenha múltiplos horários)
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
                // Caso antigo com apenas uma string
                agendamentos.push({
                    title: 'Agendado: ' + valor,
                    start: data,
                    color: '#ff4d4d'
                });
            }
        } catch (e) {
            // Valor não é JSON válido, trata como string simples
            agendamentos.push({
                title: 'Agendado: ' + valor,
                start: data,
                color: '#ff4d4d'
            });
        }
    }

    // Inicializa o FullCalendar
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
        dateClick: function(info) {
            window.location.href = '../../app/views/consultas-agendadas.html?data=' + info.dateStr;
        }
    });

    // Renderiza o calendário
    calendar.render();
});

