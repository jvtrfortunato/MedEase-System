// Executar quando HTML for carregado
document.addEventListener('DOMContentLoaded', function() {

    //Recebe o SELETOR calendar do atributo id
    var calendarEl = document.getElementById('calendar');

    // Define a URL de consultas com base no tipo de usuário
    let urlConsultas = '';

    // Define a urlConsultas
    if (tipoUsuario === 'medico') {
        urlConsultas = '../config/listar-consulta-medico.php'; // SEM GET
    } else {
        urlConsultas = '../config/listar-consulta.php';
    }

    //Receber o seletor da janela modal cadastrar
    const cadastrarModal = new bootstrap.Modal(document.getElementById("cadastrarModal")); 

    //Receber o seletor da janela modal visualizar
    const visualizarModal = new bootstrap.Modal(document.getElementById("visualizarModal"));

    //Recebe o SELETOR "msgViewEvento"
    const msgViewEvento = document.getElementById('msgViewEvento');

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
        events: urlConsultas,
        

        //Identificar o clique do usuário sobre a consulta
        eventClick: function (info) {

            // Apresentar os detalhes da consulta
            document.getElementById("visualizarConsulta").style.display = "block";
            document.getElementById("visualizarModalLabel").style.display = "block";

            // Ocultar o formulário editar da consulta
            document.getElementById("editarConsulta").style.display = "none";
            document.getElementById("editarModalLabel").style.display = "none";

            //Enviar para a janela modal os dados da consulta
            document.getElementById("visualizar_id").innerText = info.event.id;
            document.getElementById("visualizar_title").innerText = info.event.title;
            document.getElementById("visualizar_nome_paciente").innerText = info.event.extendedProps.nome_paciente;
            document.getElementById("visualizar_nome_medico").innerText = "Dr(a) " + info.event.extendedProps.nome_medico;
            document.getElementById("visualizar_start").innerText = info.event.start.toLocaleString();
            document.getElementById("visualizar_end").innerText = info.event.end !== null ? info.event.end.toLocaleString() : info.event.start.toLocaleString();
            document.getElementById("visualizar_status").innerText = info.event.extendedProps.status;

            //Enviar os dados da consulta para o formulario editar
            document.getElementById("edit_id").value = info.event.id;
            document.getElementById("edit_title").value = info.event.title;
            document.getElementById("edit_nome_paciente").value = info.event.extendedProps.nome_paciente;
            document.getElementById("edit_nome_medico").value = info.event.extendedProps.nome_medico;
            document.getElementById("edit_start").value = converterData(info.event.start);
            document.getElementById("edit_end").value = info.event.end !== null ? converterData(info.event.end) : converterData(info.event.start);
            document.getElementById("edit_status").value = info.event.extendedProps.status;

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
            if (resposta.medicos.status) {
                var opcoesMedico = '<option value="">Selecione</option>';

                if (resposta.medicos.dadosMedicos.length === 1) {
                    const medico = resposta.medicos.dadosMedicos[0];
                    opcoesMedico += `<option value="${medico.id_medico}" selected>${medico.nome}</option>`;
                } else {
                    for (var i = 0; i < resposta.medicos.dadosMedicos.length; i++) {
                        opcoesMedico += `<option value="${resposta.medicos.dadosMedicos[i]['id_medico']}">${resposta.medicos.dadosMedicos[i]['nome']}</option>`;
                    }
                }

                cadNomeMedico.innerHTML = opcoesMedico;
            } else {
                cadNomeMedico.innerHTML = `<option value="">${resposta.medicos.msg}</option>`;
            }

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

    // Recebe o SELETOR da mensagem cadastrar consulta
    const msgCadConsulta = document.getElementById("msgCadConsulta");

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
                msgCadConsulta.innerHTML = `<div class="alert alert-danger" role="alert">${resposta['msg']}</div>`;

            }else{

                //Enviar a mensagem para o HTML
                msg.innerHTML = `<div class="alert alert-success" role="alert">${resposta['msg']}</div>`;

                msgCadConsulta.innerHTML = "";

                //Limpar o formulário
                formCadConsulta.reset();

                //Criar o objeto com os dados da consulta
                const novaConsulta = {
                    id: resposta['id'],
                    title: resposta['title'],
                    nome_paciente: resposta['nome_paciente'],
                    nome_medico: resposta['nome_medico'],
                    start: resposta['start'],
                    end: resposta['end'],
                    status: resposta['status_consulta'],
                }

                //Adicionar consulta ao calendário
                calendar.addEvent(novaConsulta);

                //Chamar a função removar a msg apos 3 segundos
                removerMsg()/

                //Fechar a janela modal
                cadastrarModal.hide();
            }
            
            //Apresentar no botão o texto cadastrar
            btnCadConsulta.value = "Cadastrar";

        });
    }

    //Função para remover a mensagem após 3 segundos
    function removerMsg() {
        setTimeout(() => {
            document.getElementById('msg').innerHTML = "";
        }, 3000)
    }

    //Receber o SELETOR ocultar formulário editar consulta e apresentar os detalhes da consulta
    const btnViewEditConsulta = document.getElementById("btnViewEditConsulta");

    //Somente acessa o IF quando existir o SELETOR "btnViewEditConsulta"
    if(btnViewEditConsulta){

        // Aguardar o usuário clica no botão editar
        btnViewEditConsulta.addEventListener("click", async () => {

            // Ocultar os detalhes da consulta
            document.getElementById("visualizarConsulta").style.display = "none";
            document.getElementById("visualizarModalLabel").style.display = "none";

            //Apresentar o formulário editar do evento
            document.getElementById("editarConsulta").style.display = "block";
            document.getElementById("editarModalLabel").style.display = "block";

            //Receber o nome do paciente da consulta
            var pacienteNome = document.getElementById("visualizar_nome_paciente").innerText;

            //Receber o nome do médico da consulta
            var medicoNome = document.getElementById("visualizar_nome_medico").innerText;
            
            //Receber o SELETOR do campo paciente do formulário editar
            var editNomePaciente = document.getElementById("edit_nome_paciente");

            //Receber o SELETOR do campo médico do formulário cadastrar
            var editNomeMedico = document.getElementById("edit_nome_medico");
            
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
                    opcoesPaciente += `<option value="${resposta.pacientes.dadosPacientes[i]['id_paciente']}" ${pacienteNome == resposta.pacientes.dadosPacientes[i]['nome'] ? 'selected' : ""}>${resposta.pacientes.dadosPacientes[i]['nome']}</option>`;
                }

                //Enviar as opções para o campo select no HTML
                editNomePaciente.innerHTML = opcoesPaciente;

            }else{

                // Enviar a opção vazia para o campo select no HTML
                editNomePaciente.innerHTML = `<option value="">${resposta.pacientes.msg}</option>`;

            }

            //Acessar o IF quando encotrar o médico no banco de dados
            if(resposta.medicos.status){

                // Criar a opção selecione para o campo select médicos
                var opcoesMedico = '<option value="">Selecione</option>'

                // Percorrer a lista de usuários
                for (var i = 0; i < resposta.medicos.dadosMedicos.length; i++){

                    //Criar a lista de opções para o campo select médicos
                    opcoesMedico += `<option value="${resposta.medicos.dadosMedicos[i]['id_medico']}" ${medicoNome == "Dr(a) " + resposta.medicos.dadosMedicos[i]['nome'] ? 'selected' : ""}>${resposta.medicos.dadosMedicos[i]['nome']}</option>`;
                }

                //Enviar as opções para o campo select no HTML
                editNomeMedico.innerHTML = opcoesMedico;

            }else{

                // Enviar a opção vazia para o campo select no HTML
                editNomeMedico.innerHTML = `<option value="">${resposta.medicos.msg}</option>`;

            }
        });
    }

    //Receber o SELETOR ocultar formulário editar consulta e apresentar os detalhes da consulta
    const btnViewConsulta = document.getElementById("btnViewConsulta");

    //Somente acessa o IF quando existir o SELETOR "btnViewEditConsulta"
    if(btnViewConsulta){

        // Aguardar o usuário clica no botão editar
        btnViewConsulta.addEventListener("click", () => {

            // Apresentar os detalhes da consulta
            document.getElementById("visualizarConsulta").style.display = "block";
            document.getElementById("visualizarModalLabel").style.display = "block";

            // Ocultar o formulário editar da consulta
            document.getElementById("editarConsulta").style.display = "none";
            document.getElementById("editarModalLabel").style.display = "none";
        });
    }

    //Receber o SELETOR do formulario editar
    const formEditConsulta = document.getElementById("formEditConsulta");

    //Receber o SELETOR da mensagem editar evento 
    const msgEditConsulta = document.getElementById("msgEditConsulta");

    //Receber o SELETOR do botão editar evento
    const btnEditConsulta = document.getElementById("btnEditConsulta");

    //Somente acessa o IF quando existir o SELETOR "formEditEvento"
    if(formEditConsulta){

        //Aguardar o usuário clicar no botao salvar
        formEditConsulta.addEventListener("submit", async (e) => {

            //Não permitir a atualização da pagina
            e.preventDefault();

            //Apresentar no botão o texto salvando
            btnEditConsulta.value = "Salvando...";

            //Receber os dados do formulário
            const dadosForm = new FormData(formEditConsulta);

            //Chamar o arquivo PHP responsável em editar a consulta
            const dados = await fetch("../config/editar-consulta.php", {
                method: "POST",
                body: dadosForm
            });

            //Realiza a leitura dos dados retornados pelo PHP
            const resposta = await dados.json();

            //Acessa o IF quando não editar com sucesso
            if(!resposta['status']){

                //Enviar a mensagem para o HTML
                msgEditConsulta.innerHTML = `<div class="alert alert-danger" role="alert">${resposta['msg']}</div>`;
            } else {

                //Enviar a mensagem para o HTML
                msg.innerHTML = `<div class="alert alert-success" role="alert">${resposta['msg']}</div>`;

                //Limpar o formulário
                formEditConsulta.reset();

                // Recuperar a consulta no FullCalendar pelo id
                const eventoExiste = calendar.getEventById(resposta['id']);

                //Verifica se encontrou a consulta no FullCalendar
                if(eventoExiste){

                    // Atualizar os atributos do evento com os novos valores do banco de dados
                    eventoExiste.setProp('title', resposta['title']);
                    eventoExiste.setStart(resposta['start']);
                    eventoExiste.setEnd(resposta['end']);

                    // Definir propriedades personalizadas corretamente
                    eventoExiste.setExtendedProp('nome_paciente', resposta['nome_paciente']);
                    eventoExiste.setExtendedProp('nome_medico', resposta['nome_medico']);
                    eventoExiste.setExtendedProp('status_consulta', resposta['status_consulta']);
                }

                // Chamar a função para remover a mensagem após 3 segundos
                removerMsg();

                // Fechar a janela Modal
                visualizarModal.hide(); 

            }

            //Apresentar no botão o texto salvar
            btnEditConsulta.value = "Salvar";
        });

    }

    //Receber o SELETOR apagar evento
    const btnApagarConsulta = document.getElementById("btnApagarConsulta");

    // Somente acessa o IF quando existir o SELETOR "btnApagarConsulta"
    if(btnApagarConsulta) {

        //Aguardar o usuário clicar no botão apagar
        btnApagarConsulta.addEventListener("click", async () => {
            
            // Exibir uma caixa de diálogo de confirmação
            const confirmacao = window.confirm("Tem certeza que deseja apagar o evento?");

            //Verificar se o usuário confirmou
            if(confirmacao) {
                
                // Receber o id da consulta
                var idConsulta = document.getElementById("visualizar_id").textContent;

                // Chamar o arquivo PHP responsável por apagar a consulta
                const dados = await fetch("../config/apagar-consulta.php?id=" + idConsulta);  
                
                // Realizar a leitura dos dados retornados pelo PHP
                const resposta = await dados.json();

                // Acessa o IF quando não apagar com sucesso
                if(!resposta['status']){

                    // Enviar a mensagem para o HTML
                    msgViewEvento.innerHTML = `<div class="alert alert-danger" role="alert">${resposta['msg']}</div>`;
                } else {

                    // Enviar a mensagem para o HTML
                    msg.innerHTML = `<div class="alert alert-success" role="alert">${resposta['msg']}</div>`;

                    // Enviar a mensagem para o HTML
                    msgViewEvento.innerHTML = "";

                    // Recuperar o evento no FullCalendar
                    const eventoExisteRemover = calendar.getEventById(idConsulta);

                    //Verificar se encontrou o evento no FullCalendar
                    if(eventoExisteRemover){

                        //Remover o evento do calendário
                        eventoExisteRemover.remove();
                    }

                    //Chamar a função para remover a mensagem após 3 segundos 
                    removerMsg();

                    //Fechar  a janela modal 
                    visualizarModal.hide();

                }
            }
        });

    }
});