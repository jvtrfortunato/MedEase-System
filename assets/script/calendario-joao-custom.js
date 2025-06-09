// Executar quando HTML for carregado
document.addEventListener('DOMContentLoaded', function() {

    //Recebe o SELETOR calendar do atributo id
    var calendarEl = document.getElementById('calendar');

    //Instacia o FullCalendar e o atribui à variável calendar
    var calendar = new FullCalendar.Calendar(calendarEl, {

        themeSystem: 'bootstrap5',

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
        
        //Chamar o arquivo PHP para recuperar as consultas
        events: '../config/listar-consulta.php',

        //Identificar o clique do usuário sobre a consulta
        eventClick: function (info) {

            //Receber o seletor da janela modal visualizar
            const visualizarModal = new bootstrap.Modal(document.getElementById("visualizarModal"));

            //Enviar para a janela modal os dados da consulta
            document.getElementById("visualizar_title").innerText = info.event.title;
            document.getElementById("visualizar_nome_paciente").innerText = info.event.extendedProps.nome_paciente;
            document.getElementById("visualizar_nome_medico").innerText = info.event.extendedProps.nome_medico;
            document.getElementById("visualizar_start").innerText = info.event.start.toLocaleString();
            document.getElementById("visualizar_end").innerText = info.event.end !== null ? info.event.end.toLocaleString() : info.event.start.toLocaleString();
            document.getElementById("visualizar_status").innerText = info.event.extendedProps.status;

            //Abrir a janela modal cadastrarModal
            visualizarModal.show();
        },
        // Abrir a janela modal cadastrar quando clicar sobre o dia no calendário
        select: async function(info){  

            //Receber o SELETOR do campo paciente do formulário cadastrar
            var cadNomePaciente = document.getElementById("cad_nome_paciente");

            //Receber o SELETOR do campo médico do formulário cadastrar
            var cadNomeMedico = document.getElementById("cad_nome_medico");

            //Chamar o arquivo PHP responsável em recuperar os pacientes e médicos
            const dados = await fetch('../config/listar-usuarios.php');

            // Ler os dados
            const resposta = await dados.json();

            //Acessar o IF quando encotrar o paciente no banco de dados
            if(resposta.pacientes.status){

                // Criar a opção selecione para o campo select pacientes
                var opcoesPaciente = '<option value="">Selecione</option>'

                // Percorrer a lista de usuários
                for (var i = 0; i < resposta.pacientes.dadosPacientes.length; i++){

                    //Criar a lista de opções para o campo select pacientes
                    opcoesPaciente += `<option value="${resposta.pacientes.dadosPacientes[i]['id_paciente']}">${resposta.pacientes.dadosPacientes[i]['nome']}</option>`;
                }

                //Enviar as opções para o campo select no HTML
                cadNomePaciente.innerHTML = opcoesPaciente;

            }else{

                // Enviar a opção vazia para o campo select no HTML
                cadNomePaciente.innerHTML = `<option value="">${resposta.pacientes.msg}</option>`;

            }

            //Acessar o IF quando encotrar o médico no banco de dados
            if(resposta.medicos.status){

                // Criar a opção selecione para o campo select médicos
                var opcoesMedico = '<option value="">Selecione</option>'

                // Percorrer a lista de usuários
                for (var i = 0; i < resposta.medicos.dadosMedicos.length; i++){

                    //Criar a lista de opções para o campo select médicos
                    opcoesMedico += `<option value="${resposta.medicos.dadosMedicos[i]['id_medico']}">${resposta.medicos.dadosMedicos[i]['nome']}</option>`;
                }

                //Enviar as opções para o campo select no HTML
                cadNomeMedico.innerHTML = opcoesMedico;

            }else{

                // Enviar a opção vazia para o campo select no HTML
                cadNomeMedico.innerHTML = `<option value="">${resposta.medicos.msg}</option>`;

            }

            //Receber o seletor da janela modal cadastrar
            const cadastrarModal = new bootstrap.Modal(document.getElementById("cadastrarModal"));

            //Chamar a função para converter a data selecionada para ISO8601 e enviar para o formulário
            document.getElementById("cad_start").value = converterData(info.start);
            document.getElementById("cad_end").value = converterData(info.start);

            // Abrir a janela modal cadastrar
            cadastrarModal.show();
            
        }
    });

    // Renderizar o calendário
    calendar.render();

    //Converter a data
    function converterData(data) {
        
        //Converter a string em um objeto Date
        const dataObj = new Date(data);

        //Extrair o ano da data
        const ano = dataObj.getFullYear();

        //Obter o mês, mês começa de 0, padStart adiciona zeros à esquerda para garantir que o mês tenha dígitos
        const mes = String(dataObj.getMonth() + 1).padStart(2, '0');

        //Obter o dia do mês, padStart adiciona zeros à esquerda para garantir que o dia tenha dois dígitos
        const dia = String(dataObj.getDate()).padStart(2, '0');

        //Obter a hora, padStart adiciona zeros à esquerda para garantir que a hora tenha dois dígitos
        const hora = String(dataObj.getHours()).padStart(2, '0');

        //Obter o minuto, padStart adiciona zeros à esquerda para garantir que o minuto tenha dois dígitos
        const minuto = String(dataObj.getMinutes()).padStart(2, '0');

        //Retornar a data
        return `${ano}-${mes}-${dia} ${hora}:${minuto}`;
    }

    // Receber o SELETOR do formulário cadastrar consulta
    const formCadConsulta = document.getElementById("formCadConsulta");

    // Receber o SELETOR da mensagem genérica
    const msg = document.getElementById("msg");

    // Receber o SELETOR do botão da janela modal cadastrar consulta
    const btnCadConsulta = document.getElementById("btnCadConsulta");

    // Somente acessa o IF quando existir o SELETOR "formCadConsulta"
    if(formCadConsulta){

        // Aguardar o usuário clicar no botão cadastrar
        formCadConsulta.addEventListener("submit", async (e) => {

            //Não permitir a atualização da página
            e.preventDefault();

            //Apresentar no botão o texto salvando
            btnCadConsulta.value = "Salvando...";

            // Receber os dados do formulário
            const dadosForm = new FormData(formCadConsulta);

            // Chamar o arquivo PHP responsável em salvar a marca
            const dados = await fetch("../config/cadastrar-consulta.php", {
                method: "POST",
                body: dadosForm
            });

            // Realizar a leitura dos dados retornados pelo PHP
            const resposta = await dados.json();
            
            // Acessa o IF quando não cadastrar com sucesso
            if(!resposta['status']){
                
                //Enviar a mensagem para o HTML
                document.getElementById("msgCadConsulta").innerHTML = `<div class="alert alert-danger" role="alert">${resposta['msg']}</div>`;
                
                //Limpar o formulário
                formCadConsulta.reset();

                //Criar o objeto com os dados da consulta
                const novaConsulta = {
                    id: resposta['id'],
                    id: resposta['id'],
                    id: resposta['id'],
                    id: resposta['id'],
                    id: resposta['id'],
                    id: resposta['id'],
                }

                //Adicionar a consulta ao calendário

            }else{

                //Enviar a mensagem para o HTML
                msg.innerHTML = `<div class="alert alert-success" role="alert">${resposta['msg']}</div>`;

            }
            
            //Apresentar no botão o texto cadastrar
            btnCadConsulta.value = "Cadastrar";

        });
    }
});