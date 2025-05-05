document.addEventListener("DOMContentLoaded", () => {
    const voltarPagina = document.getElementById("voltarPagina2");

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
