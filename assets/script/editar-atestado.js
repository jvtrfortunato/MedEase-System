// Aleternar entre os botões
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
        dados.data = document.querySelector('#form-comparecimento input[name="data"]').value;
        dados.horarioChegada = document.querySelector('#form-comparecimento input[name="horarioChegada"]').value;
        dados.horarioSaida = document.querySelector('#form-comparecimento input[name="horarioSaida"]').value;
        dados.cid10 = document.querySelector('#form-comparecimento input[name="cid10"]').value;
        dados.textoPrincipal = document.querySelector('#form-comparecimento textarea[name="textoPrincipal"]').value;
    }

    if (tipoSelecionado === 'afastamento') {
        dados.diasAfastamento = document.querySelector('#form-afastamento input[name="numeroDias"]').value;
        dados.dataInicio = document.querySelector('#form-afastamento input[name="dataInicio"]').value;
        dados.dataRetorno = document.querySelector('#form-afastamento input[name="dataRetorno"]').value;
        dados.cid10 = document.querySelector('#form-afastamento input[name="cid10"]').value;
        dados.textoPrincipal = document.querySelector('#form-afastamento textarea[name="textoPrincipal"]').value;
    }

    if (tipoSelecionado === 'acompanhante') {
        dados.nomeAcompanhante = document.querySelector('#form-acompanhante input[name="nomeAcompanhante"]').value;
        dados.cpfAcompanhante = document.querySelector('#form-acompanhante input[name="cpfAcompanhante"]').value;
        dados.parentesco = document.querySelector('#form-acompanhante input[name="parentesco"]').value;
        dados.data = document.querySelector('#form-acompanhante input[name="data"]').value;
        dados.horarioChegada = document.querySelector('#form-acompanhante input[name="horarioChegada"]').value;
        dados.horarioSaida = document.querySelector('#form-acompanhante input[name="horarioSaida"]').value;
        dados.cid10 = document.querySelector('#form-acompanhante input[name="cid10"]').value;
        dados.textoPrincipal = document.querySelector('#form-acompanhante textarea[name="textoPrincipal"]').value;
    }

    localStorage.setItem('atestado', JSON.stringify(dados));
    
    // Recupera o ID da consulta da URL atual (se presente)
    const urlParams = new URLSearchParams(window.location.search);
    const consultaId = urlParams.get('consulta_id');

    // Redireciona com o parâmetro consulta_id
    if (consultaId) {
        window.location.href = `editar-prontuario.php?consulta_id=${consultaId}`;
    } else {
        alert("ID da consulta não encontrado. Não foi possível voltar para o prontuário.");
    }
});

window.onload = function () {
    const dados = JSON.parse(localStorage.getItem('atestado'));
    console.log(dados);
    if (!dados) return;

    selecionarTipo(dados.tipo); // Ativa o formulário correto

    if (dados.tipo === 'comparecimento') {
        document.querySelector('#form-comparecimento input[name="data"]').value = dados.data || '';
        document.querySelector('#form-comparecimento input[name="horarioChegada"]').value = dados.horarioChegada || '';
        document.querySelector('#form-comparecimento input[name="horarioSaida"]').value = dados.horarioSaida || '';
        document.querySelector('#form-comparecimento input[name="cid10"]').value = dados.cid10 || '';
        document.querySelector('#form-comparecimento textarea[name="textoPrincipal"]').value = dados.textoPrincipal || '';
    }

    if (dados.tipo === 'afastamento') {
        document.querySelector('#form-afastamento input[name="numeroDias"]').value = dados.diasAfastamento || '';
        document.querySelector('#form-afastamento input[name="dataInicio"]').value = dados.dataInicio || '';
        document.querySelector('#form-afastamento input[name="dataRetorno"]').value = dados.dataRetorno || '';
        document.querySelector('#form-afastamento input[name="cid10"]').value = dados.cid10 || '';
        document.querySelector('#form-afastamento textarea[name="textoPrincipal"]').value = dados.textoPrincipal || '';
    }

    if (dados.tipo === 'acompanhante') {
        document.querySelector('#form-acompanhante input[name="nomeAcompanhante"]').value = dados.nomeAcompanhante || '';
        document.querySelector('#form-acompanhante input[name="cpfAcompanhante"]').value = dados.cpfAcompanhante || '';
        document.querySelector('#form-acompanhante input[name="parentesco"]').value = dados.parentescoAcompanhante || '';
        document.querySelector('#form-acompanhante input[name="data"]').value = dados.data || '';
        document.querySelector('#form-acompanhante input[name="horarioChegada"]').value = dados.horarioChegada || '';
        document.querySelector('#form-acompanhante input[name="horarioSaida"]').value = dados.horarioSaida || '';
        document.querySelector('#form-acompanhante input[name="cid10"]').value = dados.cid10 || '';
        document.querySelector('#form-acompanhante textarea[name="textoPrincipal"]').value = dados.textoPrincipal || '';
    }
}

document.getElementById('botaoVoltar').addEventListener('click', () => {

    // Recupera o ID da consulta da URL atual (se presente)
    const urlParams = new URLSearchParams(window.location.search);
    const consultaId = urlParams.get('consulta_id');

    // Redireciona com o parâmetro consulta_id
    if (consultaId) {
        window.location.href = `editar-prontuario.php?consulta_id=${consultaId}`;
    } else {
        alert("ID da consulta não encontrado. Não foi possível voltar para o prontuário.");
    }
});
