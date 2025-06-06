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
        //initialDate: '2023-01-12',
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
        
        
        events: '../config/listar-evento.php'
    });

    calendar.render();
});