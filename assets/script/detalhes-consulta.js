// Aguarda o carregamento completo do DOM para iniciar a execução do script
document.addEventListener("DOMContentLoaded", () => {
    // Seleciona o botão de confirmar consulta
    const botaoConfirmar = document.getElementById("confirmar-consulta");

    // Recupera do localStorage a data e hora selecionadas na tela anterior
    const dataSelecionada = localStorage.getItem("dataSelecionada");
    const horaSelecionada = localStorage.getItem("horaSelecionada");

    // Seleciona os campos de data e hora no formulário
    const campoData = document.querySelector('input[name="data"]');
    const campoHora = document.querySelector('input[name="hora"]');

    // Se já existe uma data salva, preenche o campo com ela; senão, usa a data atual
    if (dataSelecionada) {
        campoData.value = dataSelecionada;
    } else {
        const hoje = new Date().toISOString().split("T")[0]; // Formato AAAA-MM-DD
        campoData.value = hoje;
    }

    // Se já existe uma hora salva, preenche o campo com ela; senão, usa a hora atual
    if (horaSelecionada) {
        campoHora.value = horaSelecionada;
    } else {
        const agora = new Date();
        const horaAtual = agora.toTimeString().split(":").slice(0, 2).join(":"); // Formato HH:MM
        campoHora.value = horaAtual;
    }

    // Evento de clique no botão "Confirmar Consulta"
    botaoConfirmar.addEventListener("click", () => {
        // Verifica se há data e hora válidas
        if (dataSelecionada && horaSelecionada) {
            // Busca os horários já agendados para a data
            let horariosAgendados = JSON.parse(localStorage.getItem(dataSelecionada)) || [];

            // Se o horário ainda não está na lista, adiciona e salva novamente no localStorage
            if (!horariosAgendados.includes(horaSelecionada)) {
                horariosAgendados.push(horaSelecionada);
                localStorage.setItem(dataSelecionada, JSON.stringify(horariosAgendados));
            }

            // Redireciona para a página de horários da data, já com a data passada por parâmetro na URL
            localStorage.setItem("modo", "agendar");

            const modo = localStorage.getItem("modo") || "consultas";

            if (modo === "agendar") {
                window.location.href = `agendar-consultas.php?modo=agendar&data=${dataSelecionada}`;
            } else {
                window.location.href = `consultas-agendadas.php?modo=agendar&data=${dataSelecionada}`;
            }


        } else {
            // Exibe erro se data ou hora estiverem ausentes
            alert("Erro ao confirmar consulta. Tente novamente.");
        }
    });

    // Evento para o botão "Voltar" (se existir)
    if (voltarPagina) {
        voltarPagina.addEventListener("click", () => {
            if (window.history.length > 1) {
                window.history.back(); // volta à página anterior no histórico
            } else {
                // Fallback: redireciona manualmente caso não haja histórico
                window.location.href = "consultas-agendadas.php";
            }
        });
    }


    
});

