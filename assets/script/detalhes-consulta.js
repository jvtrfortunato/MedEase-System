
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

    const btnCancelar = document.getElementById("cancelarConsulta");

    btnCancelar.addEventListener("click", () => {
        const data = localStorage.getItem("dataSelecionada");
        const hora = localStorage.getItem("horaSelecionada");

        if (data && hora) {
            // Pega a lista de horários agendados para a data
            let horariosAgendados = JSON.parse(localStorage.getItem(data)) || [];

            // Remove a hora atual da lista (desocupa)
            const index = horariosAgendados.indexOf(hora);
            if (index > -1) {
                horariosAgendados.splice(index, 1); // remove a hora
                localStorage.setItem(data, JSON.stringify(horariosAgendados)); // atualiza o localStorage
            }

            // Remove hora e data selecionadas (opcional)
            localStorage.removeItem("horaSelecionada");
            localStorage.removeItem("dataSelecionada");
        }

        // Redireciona de volta para a tela de agendamento
        window.location.href = "consultas-agendadas.html?data=" + data;
    });

    // Recupera do localStorage a data e a hora que o usuário selecionou na tela anterior
    const data = localStorage.getItem("dataSelecionada");
    const hora = localStorage.getItem("horaSelecionada");

    // Verifica se os valores foram encontrados (ou seja, se o usuário veio da página anterior)
    if (data && hora) {
        // Converte a data do formato "aaaa-mm-dd" para "dd/mm/aaaa" para exibir corretamente no campo
        const dataFormatada = data.split("-").reverse().join("/");

        // Define os valores dos campos de entrada no formulário com os dados recuperados
        document.getElementById("data").value = dataFormatada;
        document.getElementById("hora").value = hora;
    }
  
});

