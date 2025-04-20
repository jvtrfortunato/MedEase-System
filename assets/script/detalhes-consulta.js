
document.addEventListener("DOMContentLoaded", () => {
    const botaoConfirmar = document.getElementById("confirmar-consulta");

    botaoConfirmar.addEventListener("click", () => {
        const dataSelecionada = localStorage.getItem("dataSelecionada");
        const horaSelecionada = localStorage.getItem("horaSelecionada");

        if (dataSelecionada && horaSelecionada) {
            // Recupera os horários já agendados dessa data
            let horariosAgendados = JSON.parse(localStorage.getItem(dataSelecionada)) || [];

            // Evita duplicidade
            if (!horariosAgendados.includes(horaSelecionada)) {
                horariosAgendados.push(horaSelecionada);
                localStorage.setItem(dataSelecionada, JSON.stringify(horariosAgendados));
            }

            // Limpa os dados temporários
            localStorage.removeItem("horaSelecionada");
            localStorage.removeItem("dataSelecionada");

            // Volta para a tela anterior (onde o horário será mostrado como agendado)
            window.location.href = `consultas-agendadas.html?data=${dataSelecionada}`;
        } else {
            alert("Erro ao confirmar consulta. Tente novamente.");
        }
    });

    let voltarPagina = document.getElementById("voltarPagina");

    voltarPagina.addEventListener("click", () => {
            window.history.back();
    });

 
    
});

