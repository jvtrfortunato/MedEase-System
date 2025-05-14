document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('telefone').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

        value = value.slice(0, 11); // Limita a 11 dígitos

        if (value.length >= 2) value = value.replace(/^(\d{2})(\d)/, '($1)$2');
        if (value.length >= 7) value = value.replace(/(\d{5})(\d)/, '$1-$2');

        e.target.value = value;
    });
});

