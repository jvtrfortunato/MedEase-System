document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const dataSelecionada = urlParams.get("data");

    // Mostra a data no título da página (ex: 20/04/2025)
    if (dataSelecionada) {
        document.querySelector("h1").textContent = dataSelecionada.split("-").reverse().join("/");
    }

    const horarios = document.querySelectorAll(".horario");

    // Recupera os horários agendados para essa data no localStorage
    let horariosAgendados = JSON.parse(localStorage.getItem(dataSelecionada)) || [];

    // Marca visualmente os horários já agendados
    horarios.forEach(horario => {
        const horaTexto = horario.querySelector(".hora").textContent;

        if (horariosAgendados.includes(horaTexto)) {
            marcarHorarioAgendado(horario);
        }

        // Evento de clique no horário
        horario.addEventListener("click", () => {
            const horaTexto = horario.querySelector(".hora").textContent;

            if (horariosAgendados.includes(horaTexto)) {
                // Cancela o agendamento
                cancelarHorario(horario, horaTexto);
            } else {
                // Armazena data e hora selecionadas no localStorage
                // Clicar em qualquer horário leva para a tela de detalhes (sem agendar ainda)
                localStorage.setItem("horaSelecionada", horaTexto);
                localStorage.setItem("dataSelecionada", dataSelecionada);
                window.location.href = "../../app/views/detalhes-consulta.html";
                // Redireciona para a página de detalhes da consulta
                window.location.href = "detalhes-consulta.html";
            }
        });
    });

    const cancelar = document.getElementById("cancelarConsulta");
    cancelar.onclick(() => {
        localStorage.removeItem("dataSelecionada");
        localStorage.removeItem("horaSelecionada");
    })

    // Função para marcar visualmente como agendado

    function marcarHorarioAgendado(horarioEl) {
        const horaTexto = horarioEl.querySelector(".hora")?.textContent || "00:00";
    
        horarioEl.classList.add("agendado");
        
        // Insere o conteúdo com o botão de ver detalhes
        horarioEl.innerHTML = `
            <div class="info">
                <p class="hora">${horaTexto}</p>
                <p class="italico">Agendado</p>
            </div>
            <a href="../../app/views/detalhes-consulta.html" class="ver-detalhes">Ver detalhes</a>
        `;
    
        // Impede o clique no link de propagar para o container
        const link = horarioEl.querySelector(".ver-detalhes");
        link.addEventListener("click", function (event) {
            event.stopPropagation(); // Impede conflito com o clique no horário
        });
    }
    
    

});


