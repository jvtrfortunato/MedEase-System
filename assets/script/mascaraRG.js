document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('rg').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

        value = value.slice(0, 9); // Limita a 9 dígitos

        if (value.length > 2) value = value.replace(/^(\d{2})(\d)/, '$1.$2');
        if (value.length > 5) value = value.replace(/(\d{3})(\d)/, '$1.$2');
        if (value.length > 8) value = value.replace(/(\d{3})(\d{1})$/, '$1-$2');

        e.target.value = value;
    });
});
