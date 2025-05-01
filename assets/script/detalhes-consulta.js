document.addEventListener("DOMContentLoaded", () => {
    const botaoConfirmar = document.getElementById("confirmar-consulta");

    const dataSelecionada = localStorage.getItem("dataSelecionada");
    const horaSelecionada = localStorage.getItem("horaSelecionada");

    // Preenche os campos de data e hora com os valores salvos ou com data/hora atual
    const campoData = document.querySelector('input[name="data"]');
    const campoHora = document.querySelector('input[name="hora"]');

    if (dataSelecionada) {
        campoData.value = dataSelecionada;
    } else {
        const hoje = new Date().toISOString().split("T")[0];
        campoData.value = hoje;
    }

    if (horaSelecionada) {
        campoHora.value = horaSelecionada;
    } else {
        const agora = new Date();
        const horaAtual = agora.toTimeString().split(":").slice(0, 2).join(":");
        campoHora.value = horaAtual;
    }

    botaoConfirmar.addEventListener("click", () => {
        if (dataSelecionada && horaSelecionada) {
            let horariosAgendados = JSON.parse(localStorage.getItem(dataSelecionada)) || [];

            if (!horariosAgendados.includes(horaSelecionada)) {
                horariosAgendados.push(horaSelecionada);
                localStorage.setItem(dataSelecionada, JSON.stringify(horariosAgendados));
            }

            // window.location.href para voltar e passar data como parâmetro
            window.location.href = `consultas-agendadas.html?data=${dataSelecionada}`;
        } else {
            alert("Erro ao confirmar consulta. Tente novamente.");
        }
    });

    const voltarPagina = document.getElementById("voltarPagina");
    if (voltarPagina) {
        voltarPagina.addEventListener("click", () => {
            window.history.back();
        });
    }


});

