document.addEventListener("DOMContentLoaded", function () {
    const cnsInput = document.getElementById('cns');

    cnsInput.addEventListener('input', function () {
        let valor = cnsInput.value.replace(/\D/g, '');

        // Limita a 15 dígitos (sem contar espaços)
        valor = valor.substring(0, 15);

        if (valor.length > 3) {
            valor = valor.replace(/^(\d{3})(\d)/, '$1 $2');
        }
        if (valor.length > 7) {
            valor = valor.replace(/^(\d{3}) (\d{4})(\d)/, '$1 $2 $3');
        }
        if (valor.length > 11) {
            valor = valor.replace(/^(\d{3}) (\d{4}) (\d{4})(\d)/, '$1 $2 $3 $4');
        }

        cnsInput.value = valor;
    });
});
