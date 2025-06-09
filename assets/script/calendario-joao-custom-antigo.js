// Executar quando HTML for carregado
document.addEventListener('DOMContentLoaded', function() {

    //Recebe o SELETOR calendar do atributo id
    var calendarEl = document.getElementById('calendar');

    //Receber o SELETOR da janela modal cadastrar
    const cadastrarModal = new bootstrap.Modal(document.getElementById("cadastrarModal"));     

    //Receber o SELETOR da janela modal visualizar
    const visualizarModal = new bootstrap.Modal(document.getElementById("visualizarModal"));

    //Recebe o SELETOR "msgViewEvento"
    const msgViewEvento = document.getElementById('msgViewEvento');

    //Instacia o FullCalendar e o atribui à variável calendar
    var calendar = new FullCalendar.Calendar(calendarEl, {

        //Incluir bootsrap 5
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
        
        //Recebe as informações do banco de dados
        events: '../config/listar-evento.php',

        //Identificar o clique do usuário sobre a consulta
        eventClick: function (info) {

            //Apresentar os detalhes da consulta
            document.getElementById("visualizarEvento").style.display = "block";
            document.getElementById("visualizarModalLabel").style.display = "block";

            //Ocultar o formulário editar do evento
            document.getElementById("editarEvento").style.display = "none";
            document.getElementById("editarModalLabel").style.display = "none";

            //Enviar para a janela modal os dados 
            document.getElementById("visualizar_id").innerText = info.event.id;
            document.getElementById("visualizar_title").innerText = info.event.title;
            document.getElementById("visualizar_obs").innerText = info.event.extendedProps.obs;
            document.getElementById("visualizar_user_id").innerText = info.event.extendedProps.user_id;
            document.getElementById("visualizar_name").innerText = info.event.extendedProps.name;
            document.getElementById("visualizar_email").innerText = info.event.extendedProps.email;
            document.getElementById("visualizar_start").innerText = info.event.start.toLocaleString();
            document.getElementById("visualizar_end").innerText = info.event.end !== null ? info.event.end.toLocaleString() : info.event.start.toLocaleString();

            //Enviar os dados do evento para o formulário editar 
            document.getElementById("edit_id").value = info.event.id;
            document.getElementById("edit_title").value = info.event.title;
            document.getElementById("edit_obs").value = info.event.extendedProps.obs;
            document.getElementById("edit_start").value = converterData(info.event.start);
            document.getElementById("edit_end").value = info.event.end !== null ? converterData(info.event.end) : converterData(info.event.start);
            document.getElementById("edit_color").value = info.event.backgroundColor;

            //Abrir a janela modal
            visualizarModal.show();
        },
        // Abrir a janela modal cadastrar quando clicar sobre o dia no calendário
        select: async function(info){

            // Receber o SELETOR do campo usuário do formulário cadastrar
            var cadUserId = document.getElementById('cad_user_id');

            // Chamar o arquivo PHP responsável em recuperar os usuários do banco de dados
            const dados = await fetch('../config/listar-usuarios.php');

            //Ler os dados
            const resposta = await dados.json();
            //console.log(resposta);

            // Acessar o IF quando encontrar usuário no banco de dados
            if(resposta['status']){

                // Criar a opção selecione para o campo select usuários
                var opcoes = '<option value="">Selecione</option>';

                //Percorrer a lista de usuários
                for (var i = 0; i < resposta.dados.length; i++){

                    //Criar a lista de opções para o campo select usuários
                    opcoes += `<option value="${resposta.dados[i]['id']}">${resposta.dados[i]['name']}</option>`;
                }

                // Enviar as opções para o campo select no HTML
                cadUserId.innerHTML = opcoes;

            }else{

                // Enviar a opção vazia para o campo select no HTML
                cadUserId.innerHTML = `<option value=''>${resposta['msg']}</option>`;

            }

            //Chamar a função para converter a data
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
        return `${dia}-${mes}-${ano} ${hora}:${minuto}`;
    }

    //Receber o SELETOR do formulário cadastrar evento
    const formCadEvento = document.getElementById("formCadEvento");

    //Receber o SELETOR da mensagem genérica
    const msg = document.getElementById("msg");

    //Receber o SELETOR da mensagem cadastrar evento
    const msgCadEvento = document.getElementById("msgCadEvento");

    //Receber o SELETOR do botão da janela modal cadastrar evento
    const btnCadEvento = document.getElementById("btnCadEvento");

    // Somente acessa o IF quando existir o SELETOR "formCadEvento"
    if(formCadEvento){

        // Aguardar o usuário clicar no botão cadastrar
        formCadEvento.addEventListener("submit", async(e) => {

            //Não permitir a atualização da página
            e.preventDefault();

            //Apresentar no botão o texto salvando
            btnCadEvento.value = "Salvando...";

            //Receber os dados do formulário
            const dadosForm = new FormData(formCadEvento);

            //Chamar o arquivo PHP responsável em salvar o evento
            const dados = await fetch("../config/cadastrar-evento.php", {
                method: "POST",
                body: dadosForm
            })

            //Realizar a leitura dos dados retornados pelo PHP
            const resposta = await dados.json();

            //Acessa o IF quando não cadastrar com sucesso
            if(!resposta['status']) {

                //Enviar a mensagem para o HTML
                msgCadEvento.innerHTML = `<div class="alert alert-danger" role="alert">${resposta['msg']}</div>`;
                
            }else{

                //Enviar a mensagem para o HTML
                msg.innerHTML = `<div class="alert alert-success" role="alert">${resposta['msg']}</div>`;

                msgCadEvento.innerHTML = "";

                //Limpar o formulário
                formCadEvento.reset();

                //Criar um objeto com os dados do evento
                const novoEvento = {
                    id: resposta['id'],
                    title: resposta['title'],
                    color: resposta['color'],
                    start: resposta['start'],
                    end: resposta['end'],
                    obs: resposta['obs'],
                    user_id: resposta['user_id'],
                    name: resposta['name'],
                    email: resposta['email']
                }

                //Adicionar o evento ao calendário
                calendar.addEvent(novoEvento);

                //Chamar a função para remover a mensagem de sucesso
                removerMsg();

                //Fechar a janela modal
                cadastrarModal.hide();
            }

            //Apresentar no botão o texto Cadastrar
            btnCadEvento.value = "Cadastrar";

        });
    }

    //Função para remover a mensagem após 3 segundos
    function removerMsg() {
        setTimeout(() => {
            document.getElementById('msg').innerHTML = "";
        }, 3000)
    }

    //Receber o SELETOR ocultar detalhes do evento a apresentar o formulário editar evento
    const btnViewEditEvento = document.getElementById("btnViewEditEvento");
    
    // Somente acessa o IF quando existir o SELETOR "btnViewEditEvento"
    if(btnViewEditEvento){

        //Aguardar o usuário clicar no botão editar
        btnViewEditEvento.addEventListener("click", async () => {

            //Ocultar os detalhes do evento
            document.getElementById("visualizarEvento").style.display = "none";
            document.getElementById("visualizarModalLabel").style.display = "none";

            //Apresentar o formulário editar do evento
            document.getElementById("editarEvento").style.display = "block";
            document.getElementById("editarModalLabel").style.display = "block";

            // Receber o id do usuário responsável pelo evento
            var userId = document.getElementById("visualizar_user_id").innerText;

            // Receber o SELETOR do campo usuário do formulário editar
            var editUserId = document.getElementById('edit_user_id');

            // Chamar o arquivo PHP responsável em recuperar os usuários do banco de dados
            const dados = await fetch('../config/listar-usuarios.php');

            //Ler os dados
            const resposta = await dados.json();
            //console.log(resposta);

            // Acessar o IF quando encontrar usuário no banco de dados
            if(resposta['status']){

                // Criar a opção selecione para o campo select usuários
                var opcoes = '<option value="">Selecione</option>';

                //Percorrer a lista de usuários
                for (var i = 0; i < resposta.dados.length; i++){

                    //Criar a lista de opções para o campo select usuários
                    opcoes += `<option value="${resposta.dados[i]['id']}" ${ userId == resposta.dados[i]['id'] ? 'selected' : ""}>${resposta.dados[i]['name']}</option>`;
                }

                // Enviar as opções para o campo select no HTML
                editUserId.innerHTML = opcoes;

            }else{

                // Enviar a opção vazia para o campo select no HTML
                editUserId.innerHTML = `<option value=''>${resposta['msg']}</option>`;

            }
        });
    }

    //Receber o SELETOR ocultar formulario deditar o evento e apresentar os detalhes evento
    const btnViewEvento = document.getElementById("btnViewEvento");
    
    // Somente acessa o IF quando existir o SELETOR "btnViewEvento"
    if(btnViewEvento){

        //Aguardar o usuário clicar no botão editar
        btnViewEvento.addEventListener("click", () => {

            //Apresentar os detalhes do evento
            document.getElementById("visualizarEvento").style.display = "block";
            document.getElementById("visualizarModalLabel").style.display = "block";

            //Ocultar o formulário editar do evento
            document.getElementById("editarEvento").style.display = "none";
            document.getElementById("editarModalLabel").style.display = "none";
        });
    }

    //Receber o SELETOR do formulário editar evento
    const formEditEvento = document.getElementById("formEditEvento");

    //Receber o SELETOR da mensagem editar evento 
    const msgEditEvento = document.getElementById("msgEditEvento");

    //Receber o SELETOR do botão editar evento
    const btnEditEvento = document.getElementById("btnEditEvento");

    //Somente acessa o IF quando o SELETOR "formEditEvento"
    if(formEditEvento) {

        //Aguardar o usuário clicar no botão editar
        formEditEvento.addEventListener("submit", async (e) => {

            //Não permitir a atualização da página
            e.preventDefault();

            //Apresentar no botão o texto salvando 
            btnEditEvento.value = "Salvando...";

            //Receber os dados do formulário
            const dadosForm = new FormData(formEditEvento);

            //Chamar o arquivo PHP responsável em editar o evento
            const dados = await fetch("../config/editar-evento.php", {
                method: "POST",
                body: dadosForm
            });

            //Realizar a leitura dos dados retornados pelo PHP
            const resposta = await dados.json(); 

            //Acessa o IF quando não editar com sucesso
            if(!resposta['status']){

                // Enviar mensagem para o HTML
                msgEditEvento.innerHTML = `<div class="alert alert-danger" role="alert">${resposta['msg']}</div>`;
            }else {

                // Enviar mensagem para o HTML
                msg.innerHTML = `<div class="alert alert-success" role="alert">${resposta['msg']}</div>`;

                // Enviar mensagem para o HTML
                msgEditEvento.innerHTML =  "";

                // Limpar o formulário
                formEditEvento.reset();

                // Recuperar o evento no FullCalendar pelo id
                const eventoExiste = calendar.getEventById(resposta['id']);

                //Verificar se encontrou o evento no FullCalendar pelo id
                if(eventoExiste){

                    //Atualizar os atributos do evento com os novos valores do banco de dados
                    eventoExiste.setProp('title', resposta['title']);
                    eventoExiste.setProp('color', resposta['color']);
                    eventoExiste.setExtendedProp('obs', resposta['obs']);
                    eventoExiste.setExtendedProp('user_id', resposta['user_id']);
                    eventoExiste.setExtendedProp('name', resposta['name']);
                    eventoExiste.setExtendedProp('email', resposta['email']);
                    eventoExiste.setStart(resposta['start']);
                    eventoExiste.setEnd(resposta['end']);
                }

                //Chamar a função para remover a mensagem após 3 segundos
                removerMsg();

                //Fechar a janela modal
                visualizarModal.hide();
            }

            //Apresentar no botão o texto salvar
            btnEditEvento.value = "Salvar";
        });
    }

    //Receber o SELETOR apagar evento
    const btnApagarEditEvento = document.getElementById("btnApagarEditEvento");

    if(btnApagarEditEvento){

        //Aguardar o usuário clicar no botão apagar
        btnApagarEditEvento.addEventListener("click", async () =>{
            
            //Exibir uma caixa de alerta de cofirmação
            const confirmacao = window.confirm("Tem certeza que deseja apagar este evento?");

            if(confirmacao){
                
                //Receber o id do evento
                var idEvento = document.getElementById("visualizar_id").textContent;

                //Chamar o arquivo PHP responsável apagar o evento
                const dados = await fetch("../config/apagar-evento.php?id=" + idEvento);

                //Realizar a leitura dos dados retornados pelo PHP
                const resposta = await dados.json();

                //Acessa o IF quando não cadastrar com sucesso
                if(!resposta['status']) {
                    
                    //Enviar a mensagem para o HTML
                    msgViewEvento.innerHTML = `<div class="alert alert-danger" role="alert">${resposta['msg']}</div>`;
                }else{
                    
                    //Enviar a mensagem para o HTML
                    msg.innerHTML = `<div class="alert alert-success" role="alert">${resposta['msg']}</div>`;

                    //Enviar a mensagem para o HTML
                    msgViewEvento.innerHTML = "";

                    //Recuperar o evento do FullCalendar
                    const eventoExisteRemover = calendar.getEventById(idEvento);

                    //Verificar se encontrou o evento no FullCalendar
                    if(eventoExisteRemover){

                        //Remover o evento do calendário
                        eventoExisteRemover.remove();
                    }

                    // Chamar a função para remover a mensagem após 3 segundos
                    removerMsg();

                    //Fechar a janela modal
                    visualizarModal.hide();
                    
                }
            }
        });

    }
});