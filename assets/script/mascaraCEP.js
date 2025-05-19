document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('cep').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

        value = value.slice(0, 8); // Limita a 8 dígitos

        if (value.length > 5) {
            value = value.replace(/^(\d{5})(\d)/, '$1-$2');
        }

        e.target.value = value;
    });
});
