// Espera o carregamento completo do DOM antes de executar qualquer código
document.addEventListener("DOMContentLoaded", () => {

    // Captura os parâmetros da URL (ex: ?data=2025-04-30)
    const urlParams = new URLSearchParams(window.location.search);
    const dataSelecionada = urlParams.get("data"); // Pega o valor da data selecionada

    // Se houver uma data na URL, formata ela (de AAAA-MM-DD para DD/MM/AAAA) e mostra no título <h1>
    if (dataSelecionada) {
        document.querySelector("h1").textContent = dataSelecionada.split("-").reverse().join("/");
    }

    // Seleciona todos os elementos com a classe .horario (cada bloco de horário)
    const horarios = document.querySelectorAll(".horario");

    // Busca no localStorage os horários já agendados para a data selecionada
    let horariosAgendados = JSON.parse(localStorage.getItem(dataSelecionada)) || [];

    // Percorre todos os horários exibidos na tela
    horarios.forEach(horario => {
        const horaTexto = horario.querySelector(".hora").textContent; // Ex: "08:00"

        // Se esse horário estiver agendado, aplica o estilo e ações de horário agendado
        if (horariosAgendados.includes(horaTexto)) {
            marcarHorarioAgendado(horario, horaTexto);
        }

        // Adiciona evento de clique no horário
        horario.addEventListener("click", () => {
            // Se já está agendado, não faz nada ao clicar
            if (horariosAgendados.includes(horaTexto)) return;

            // Armazena no localStorage o horário e data selecionados
            localStorage.setItem("horaSelecionada", horaTexto);
            localStorage.setItem("dataSelecionada", dataSelecionada);

            // Redireciona o usuário para a tela de detalhes da consulta
            window.location.href = "detalhes-consulta.html";
        });
    });

    // Função que marca um horário visualmente como agendado
    function marcarHorarioAgendado(horarioEl, horaTexto) {
        horarioEl.classList.add("agendado"); // Adiciona a classe de estilo

        // Substitui o conteúdo interno do horário por informações de agendamento e botões
        horarioEl.innerHTML = `
            <div class="info">
                <p class="hora">${horaTexto}</p>
                <p class="italico">Agendado</p>
            </div>
           
        `;

       
    }

   
});