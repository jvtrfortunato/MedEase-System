//Função para expandir ou retrair os campos do prontuário
function expandirRetrair(idFormulario, setaImg) {
    const formulario = document.getElementById(idFormulario);
    const visivel = formulario.classList.contains('formulario-visivel');

    if (visivel) {
        formulario.classList.remove('formulario-visivel');
        formulario.classList.add('formulario-oculto');
        setaImg.src = '../../assets/img/seta-direita.png';
    }   else {
        formulario.classList.remove('formulario-oculto');
        formulario.classList.add('formulario-visivel');
        setaImg.src = '../../assets/img/seta-baixo.png';
    }
}

//Função que exibe os exames solicitados ao voltar para o prontuário
document.addEventListener('DOMContentLoaded', function () {
    const exames = JSON.parse(localStorage.getItem('examesSolicitados')) || [];
    const lista = document.getElementById('lista-exames');
    const botao = document.getElementById('botao-exame');
    
    lista.innerHTML = '';
    exames.forEach(exame => {
        const container = document.createElement('div');
        container.classList.add('lista-exames');

        const li = document.createElement('li');
        li.textContent = exame.nomeExame;

        container.appendChild(li);
        lista.appendChild(container);
    });

    // Altera o botão se houver exames
    if (exames.length > 0) {
        botao.textContent = 'Editar exames';
    } else {
        botao.textContent = 'Solicitar exame';
    }
});

//Função que preenche o array dos exames solicitados
document.getElementById('salvarProntuario').addEventListener('submit', function() {
    const exames = JSON.parse(localStorage.getItem('examesSolicitados')) || [];
    document.getElementById('examesJSON').value = JSON.stringify(exames);
});

//Exibe os remédios
window.addEventListener('DOMContentLoaded', () => {
    const lista = document.getElementById('medicamentosPrescricao');
    const medicamentos = JSON.parse(localStorage.getItem('medicamentosPrescricao') || '[]');

    if (medicamentos.length > 0) {
        medicamentos.forEach((med, index) => {
            const container = document.createElement('div');
            container.classList.add('lista-medicamentos');

            const li = document.createElement('li');

            // Usa o campo correto dependendo da origem
            const nome = med.principioAtivo || med.nome_medicamento || '[Sem nome]';

            li.textContent = `${nome}`;

            container.appendChild(li);
            lista.appendChild(container);
        });

        // Altera o texto do botão para "Editar prescrição"
        const botao = document.getElementById('botaoPrescricao');
        botao.textContent = 'Editar prescrição';
    }
});

//Exibe o atestado
window.onload = function () {
    const atestadoSalvo = localStorage.getItem('atestado');

    if (atestadoSalvo) {
        const dados = JSON.parse(atestadoSalvo);
        const lista = document.getElementById('atestados'); 

        const container = document.createElement('div');
        container.classList.add('atestados');

        // Exibir tipo e primeiro trecho do texto
        const item = document.createElement('li');
        item.textContent = `Atestado de ${dados.tipo.charAt(0).toUpperCase() + dados.tipo.slice(1)}`;

        container.appendChild(item);
        lista.appendChild(container);

        // Mudar o texto do botão
        const botao = document.getElementById('botaoAtestado'); // ID do botão que vai para criar-atestado.php
        if (botao) {
            botao.textContent = "Editar atestado";
        }
    }
}

document.querySelector('form').addEventListener('submit', function (e) {
    
    // Recupera do localStorage
    const atestado = localStorage.getItem('atestado');
    const exames = localStorage.getItem('examesSolicitados');
    const medicamentos = localStorage.getItem('medicamentosPrescricao');
    const recomendacoes = localStorage.getItem('recomendacoesPrescricao');

    // Preenche os inputs ocultos com os dados
    if (atestado) {
        document.getElementById('atestadoJSON').value = atestado;
    }

    if (exames) {
        document.getElementById('examesJSON').value = exames;
    }

    if (medicamentos) {
        document.getElementById('medicamentosJSON').value = medicamentos;
    }

    if (recomendacoes) {
        document.getElementById('recomendacoesJSON').value = recomendacoes;
    }

    // Limpa o localStorage
    localStorage.removeItem('atestado');
    localStorage.removeItem('examesSolicitados');
    localStorage.removeItem('medicamentosPrescricao');
    localStorage.removeItem('recomendacoesPrescricao')
});

//Função para voltar para atendimentos do dia
const voltarPagina = document.getElementById("voltarPagina");

if (voltarPagina) {
    voltarPagina.addEventListener("click", () => {

        // Limpa o localStorage
        localStorage.removeItem('atestado');
        localStorage.removeItem('examesSolicitados');
        localStorage.removeItem('medicamentosPrescricao');
        localStorage.removeItem('recomendacoesPrescricao');
        
        window.location.href = "../../app/views/atendimentos-dia.php";
    });
}
