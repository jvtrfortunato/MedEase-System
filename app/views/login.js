document.getElementById('cpf').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

    if (value.length > 3) value = value.replace(/^(\d{3})(\d)/, '$1.$2');
    if (value.length > 6) value = value.replace(/(\d{3})(\d)/, '$1.$2');
    if (value.length > 9) value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

    e.target.value = value;
});