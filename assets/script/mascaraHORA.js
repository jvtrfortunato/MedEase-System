document.addEventListener("DOMContentLoaded", function () {
    const inputsHora = document.querySelectorAll('.hora');

    inputsHora.forEach(function (input) {
        input.addEventListener('input', function () {
            let valor = input.value.replace(/\D/g, ''); // só números

            valor = valor.substring(0, 4); // máximo 4 dígitos (HHMM)

            if (valor.length >= 3) {
                valor = valor.replace(/^(\d{2})(\d{1,2})/, '$1:$2');
            }

            input.value = valor;
        });
    });
});
