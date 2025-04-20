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
                localStorage.setItem("horaSelecionada", horaTexto);
                localStorage.setItem("dataSelecionada", dataSelecionada);

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
        horarioEl.classList.add("agendado");
        horarioEl.querySelector(".italico").textContent = "Agendado";
    }

});


