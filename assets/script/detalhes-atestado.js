// function selecionarTipo(tipo) {
//     const botoes = document.querySelectorAll(".botao-tipo");
//     botoes.forEach(btn => btn.classList.remove("ativo"));

//     const formularios = document.querySelectorAll(".formulario-atestado");
//     formularios.forEach(form => form.classList.remove("ativo"));

//     document.getElementById(`btn-${tipo}`).classList.add("ativo");
//     document.getElementById(`form-${tipo}`).classList.add("ativo");
// }

document.addEventListener('DOMContentLoaded', () => {
    if (typeof atestado === 'undefined') {
        console.warn('Atestado ainda não foi definido!');
        return;
    }

    if(atestado.tipo === 'acompanhante') {

        document.getElementById('form-acompanhante').classList.add("ativo");
        document.getElementById('nome-acompanhante').textContent = atestado.nomeAcompanhante;
        document.getElementById('cpf-acompanhante').textContent = atestado.cpfAcompanhante;
        document.getElementById('parentesco-acompanhante').textContent = atestado.parentescoAcompanhante;
        document.getElementById('data-acompanhante').textContent = atestado.data;
        document.getElementById('chegada-acompanhante').textContent = atestado.horarioChegada;
        document.getElementById('saida-acompanhante').textContent = atestado.horarioSaida;
        document.getElementById('cid-acompanhante').textContent = atestado.cid10;
        document.getElementById('texto-acompanhante').textContent = atestado.textoPrincipal;

    } else if(atestado.tipo === 'afastamento') {

        document.getElementById('form-afastamento').classList.add("ativo");
        document.getElementById('dias-afastamento').textContent = atestado.diasAfastamento;
        document.getElementById('inicio-afastamento').textContent = atestado.dataInicio;
        document.getElementById('retorno-afastamento').textContent = atestado.dataRetorno;
        document.getElementById('cid-afastamento').textContent = atestado.cid10;
        document.getElementById('texto-afastamento').textContent = atestado.textoPrincipal;

    } else if(atestado.tipo === 'comparecimento') {

        document.getElementById('form-comparecimento').classList.add("ativo");
        document.getElementById('data-comparecimento').textContent = atestado.data;
        document.getElementById('chegada-comparecimento').textContent = atestado.horarioChegada;
        document.getElementById('saida-comparecimento').textContent = atestado.horarioSaida;
        document.getElementById('cid-comparecimento').textContent = atestado.cid10;
        document.getElementById('texto-comparecimento').textContent = atestado.textoPrincipal;
    }
});
