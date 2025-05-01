// Aguarda o carregamento completo do DOM antes de executar o script
document.addEventListener('DOMContentLoaded', function() {

    // Verifica se há necessidade de recarregar a página (por exemplo, após cancelar uma consulta)
    if (localStorage.getItem("forceReload") === "true") {
        localStorage.removeItem("forceReload"); // Remove a flag para não recarregar sempre
        location.reload(); // Recarrega a página
        return; // Impede que o restante do código seja executado antes do reload
    }

    // Seleciona o elemento onde o calendário será renderizado (div com id="calendar")
    const calendarEl = document.getElementById('calendar');

    // Inicializa um array que armazenará os eventos (agendamentos) a serem exibidos no calendário
    const agendamentos = [];

    // Percorre todos os itens do localStorage
    for (let i = 0; i < localStorage.length; i++) {
        const data = localStorage.key(i); // Obtém a chave (que será uma data no formato "YYYY-MM-DD")
        const valor = localStorage.getItem(data); // Obtém o valor associado (pode ser array ou string)

        try {
            // Tenta converter o valor em JSON (espera-se um array de horários)
            const horarios = JSON.parse(valor);

            // Se for um array de horários
            if (Array.isArray(horarios)) {
                horarios.forEach(hora => {
                    agendamentos.push({
                        title: 'Agendado: ' + hora, // Exibe o horário no título
                        start: data, // Data do evento
                        color: '#ff4d4d' // Cor vermelha para indicar agendamento
                    });
                });
            } else {
                // Caso o valor não seja um array (estrutura antiga), trata como string única
                agendamentos.push({
                    title: 'Agendado: ' + valor,
                    start: data,
                    color: '#ff4d4d'
                });
            }
        } catch (e) {
            // Se o valor não for um JSON válido, também trata como string única
            agendamentos.push({
                title: 'Agendado: ' + valor,
                start: data,
                color: '#ff4d4d'
            });
        }
    }

    // Inicializa o FullCalendar com configurações
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Visualização mensal como padrão
        locale: 'pt-br', // Localização em português
        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia',
            list: 'Lista'
        },
        events: agendamentos, // Eventos a serem exibidos (agendamentos extraídos do localStorage)
        dateClick: function(info) {
            // Ao clicar em uma data, redireciona para a página de horários dessa data
            window.location.href = '../../app/views/consultas-agendadas.html?data=' + info.dateStr;
        }
    });

    // Renderiza o calendário na tela
    calendar.render();
});


