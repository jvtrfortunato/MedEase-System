document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'pt-br',
    buttonText: {
        today: 'Hoje',
        month: 'Mês',
        week: 'Semana',
        day: 'Dia',
        list: 'Lista'
    },
    dateClick: function(info) {
        // Redireciona para a página passando a data no formato YYYY-MM-DD
        window.location.href = '../../app/views/consultas-agendadas.html?data=' + info.dateStr;

        // Exemplo de como pegar essa data na consulta-agendadas.html:
        // const urlParams = new URLSearchParams(window.location.search);
        // const dataSelecionada = urlParams.get('data');
        // console.log('Data selecionada:', dataSelecionada);  
    }
});
calendar.render();
});