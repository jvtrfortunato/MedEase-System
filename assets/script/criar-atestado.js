function selecionarTipo(tipo) {
    const botoes = document.querySelectorAll(".botao-tipo");
    botoes.forEach(btn => btn.classList.remove("ativo"));

    const formularios = document.querySelectorAll(".formulario-atestado");
    formularios.forEach(form => form.classList.remove("ativo"));

    document.getElementById(`btn-${tipo}`).classList.add("ativo");
    document.getElementById(`form-${tipo}`).classList.add("ativo");
}

document.querySelector('.verde').addEventListener('click', function (e) {
    e.preventDefault();

    const tipoSelecionado = document.querySelector('.formulario-atestado.ativo').id.replace('form-', '');

    let dados = { tipo: tipoSelecionado };

    if (tipoSelecionado === 'comparecimento') {
        dados.data = document.querySelector('input[name="data"]').value;
        dados.horarioChegada = document.querySelector('input[name="horarioChegada"]').value;
        dados.horarioSaida = document.querySelector('input[name="horarioSaida"]').value;
        dados.cid10 = document.querySelector('input[name="cid10"]').value;
        dados.texto = document.querySelector('#form-comparecimento textarea[name="textoPrincipal"]').value;
    }

    if (tipoSelecionado === 'afastamento') {
        dados.numeroDias = document.querySelector('input[name="numeroDias"]').value;
        dados.dataInicio = document.querySelector('input[name="dataInicio"]').value;
        dados.dataRetorno = document.querySelector('input[name="dataRetorno"]').value;
        dados.cid10 = document.querySelector('input[name="cid10"]').value;
        dados.texto = document.querySelector('#form-afastamento textarea[name="textoPrincipal"]').value;
    }

    if (tipoSelecionado === 'acompanhante') {
        dados.nomeAcompanhante = document.querySelector('input[name="nomeAcompanhante"]').value;
        dados.cpfAcompanhante = document.querySelector('input[name="cpfAcompanhante"]').value;
        dados.parentesco = document.querySelector('input[name="parentesco"]').value;
        dados.data = document.querySelector('#form-acompanhante input[name="data"]').value;
        dados.horarioChegada = document.querySelector('#form-acompanhante input[name="horarioChegada"]').value;
        dados.horarioSaida = document.querySelector('#form-acompanhante input[name="horarioSaida"]').value;
        dados.cid10 = document.querySelector('input[name="cid10"]').value;
        dados.texto = document.querySelector('#form-acompanhante textarea[name="textoPrincipal"]').value;
    }

    localStorage.setItem('atestado', JSON.stringify(dados));
    window.location.href = 'prontuario.php';
});

window.onload = function () {
    const dados = JSON.parse(localStorage.getItem('atestado'));
    console.log(dados);
    if (!dados) return;

    selecionarTipo(dados.tipo); // Ativa o formulário correto

    if (dados.tipo === 'comparecimento') {
        document.querySelector('input[name="data"]').value = dados.data || '';
        document.querySelector('input[name="horarioChegada"]').value = dados.horarioChegada || '';
        document.querySelector('input[name="horarioSaida"]').value = dados.horarioSaida || '';
        document.querySelector('input[name="cid10"]').value = dados.cid10 || '';
        document.querySelector('#form-comparecimento textarea[name="textoPrincipal"]').value = dados.texto || '';
    }

    if (dados.tipo === 'afastamento') {
        document.querySelector('input[name="numeroDias"]').value = dados.numeroDias || '';
        document.querySelector('input[name="dataInicio"]').value = dados.dataInicio || '';
        document.querySelector('input[name="dataRetorno"]').value = dados.dataRetorno || '';
        document.querySelector('input[name="cid10"]').value = dados.cid10 || '';
        document.querySelector('#form-afastamento textarea[name="textoPrincipal"]').value = dados.texto || '';
    }

    if (dados.tipo === 'acompanhante') {
        document.querySelector('input[name="nomeAcompanhante"]').value = dados.nomeAcompanhante || '';
        document.querySelector('input[name="cpfAcompanhante"]').value = dados.cpfAcompanhante || '';
        document.querySelector('input[name="parentesco"]').value = dados.parentesco || '';
        document.querySelector('#form-acompanhante input[name="data"]').value = dados.data || '';
        document.querySelector('#form-acompanhante input[name="horarioChegada"]').value = dados.horarioChegada || '';
        document.querySelector('#form-acompanhante input[name="horarioSaida"]').value = dados.horarioSaida || '';
        document.querySelector('input[name="cid10"]').value = dados.cid10 || '';
        document.querySelector('#form-acompanhante textarea[name="textoPrincipal"]').value = dados.texto || '';
    }
}

//desabilita os inputs inativos
document.querySelector('form').addEventListener('submit', function () {
    // Desabilita todos os campos de atestados
    document.querySelectorAll('.formulario-atestado input, .formulario-atestado textarea').forEach(input => {
        input.disabled = true;
    });

    // Habilita apenas os campos do formulário ativo
    const ativo = document.querySelector('.formulario-atestado.ativo');
    ativo.querySelectorAll('input, textarea').forEach(input => {
        input.disabled = false;
    });
});

function selecionarTipo(tipo) {
    // Esconde todos os formulários
    document.querySelectorAll('.formulario-atestado').forEach(form => form.classList.remove('ativo'));

    // Mostra o formulário selecionado
    document.getElementById('form-' + tipo).classList.add('ativo');

    // Atualiza o campo oculto com o tipo atual
    document.getElementById('tipoAtestado').value = tipo;

    // Atualiza os botões ativos (se necessário visualmente)
    document.querySelectorAll('.botao-tipo').forEach(btn => btn.classList.remove('ativo'));
    document.getElementById('btn-' + tipo).classList.add('ativo');
}
