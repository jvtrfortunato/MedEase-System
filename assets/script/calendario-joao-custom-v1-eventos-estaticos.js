// Executar quando HTML for carregado
document.addEventListener('DOMContentLoaded', function() {

    //Recebe o SELETOR calendar do atributo id
    var calendarEl = document.getElementById('calendar');

    //Instacia o FullCalendar e o atribui à variável calendar
    var calendar = new FullCalendar.Calendar(calendarEl, {

        //Cria o cabeçalho do calendário
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        //Definir idioma usado no calendário
        locale: 'pt-br',

        //Definir a data inicial
        initialDate: '2023-01-12',
        //initialDate: '2023-10-12',

        //Permitir clicar nos nomes dos dias da semana
        navLinks: true, 

        //Permitir clicar e arrastar o mouse para selecionar vários dias
        selectable: true,

        //Indicar visualmente a área que será selecionada antes que o usuário solte o botão do mouse
        selectMirror: true,

        //Permitir arrastar e redimensionar os eventos
        editable: true,

        // Número máximo de eventos em um determinado dia, se for true, o número de eventos será limitado à altura da célula do dia
        dayMaxEvents: true, 
        
        
        events: [
            {
            title: 'All Day Event',
            start: '2023-01-01'
            },
            {
            title: 'Long Event',
            start: '2023-01-07',
            end: '2023-01-10'
            },
            {
            groupId: 999,
            title: 'Repeating Event',
            start: '2023-01-09T16:00:00'
            },
            {
            groupId: 999,
            title: 'Repeating Event',
            start: '2023-01-16T16:00:00'
            },
            {
            title: 'Conference',
            start: '2023-01-11',
            end: '2023-01-13'
            },
            {
            title: 'Meeting',
            start: '2023-01-12T10:30:00',
            end: '2023-01-12T12:30:00'
            },
            {
            title: 'Lunch',
            start: '2023-01-12T12:00:00'
            },
            {
            title: 'Meeting',
            start: '2023-01-12T14:30:00'
            },
            {
            title: 'Happy Hour',
            start: '2023-01-12T17:30:00'
            },
            {
            title: 'Dinner',
            start: '2023-01-12T20:00:00'
            },
            {
            title: 'Birthday Party',
            start: '2023-01-13T07:00:00'
            },
            {
            title: 'Click for Google',
            url: 'http://google.com/',
            start: '2023-01-28'
            }
        ]
    });

    calendar.render();
});