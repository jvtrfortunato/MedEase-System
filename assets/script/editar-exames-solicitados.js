const listaExames = [];

// Carrega exames do localStorage ao abrir a página
document.addEventListener('DOMContentLoaded', function () {
    const examesSalvos = JSON.parse(localStorage.getItem('examesSolicitados'));
    if (examesSalvos && Array.isArray(examesSalvos)) {
        examesSalvos.forEach(exame => {
            adicionarExame(exame.nomeExame); // Adiciona cada exame à lista e à interface
        });
    }
});

// Adiciona os exames na lista
function adicionarExame(nomeExame = null) {
    // Recupera o ID do exame da URL atual (se presente)
    const urlParams = new URLSearchParams(window.location.search);
    const idProntuario = urlParams.get('prontuario_id');

    const select = document.getElementById('exame');
    const lista = document.getElementById('lista-exames');

    if (!nomeExame) nomeExame = select.value;

    if (nomeExame !== '') {
        // Evita duplicatas
        if (!listaExames.some(exame => exame.nomeExame === nomeExame)) {
            // Criar objeto com os dados
            const exame = {
                idExame: 0,
                nomeExame: nomeExame,
                idProntuario: idProntuario
            };

            listaExames.push(exame);
            console.log(listaExames);

            const container = document.createElement('div');
            container.classList.add('exame-container');

            const li = document.createElement('li');
            li.classList.add('exame-item');
            li.textContent = nomeExame;

            // Criar botão de remoção
            const imgRemover = document.createElement('img');
            imgRemover.src = '../../assets/img/lixeira.png';
            imgRemover.alt = 'Remover';
            imgRemover.classList.add('lixeira');

            imgRemover.addEventListener('click', function () {
                // Remove da lista (agora corretamente)
                const index = listaExames.findIndex(exame => exame.nomeExame === nomeExame);
                if (index !== -1) {
                    listaExames.splice(index, 1);
                }

                // Remove do DOM 
                container.remove();
            });

            container.appendChild(li);
            container.appendChild(imgRemover);
            lista.appendChild(container);

        } else {
            alert("Esse exame já foi adicionado.");
        }
    } else {
        alert("Selecione um exame.");
    }
}

function finalizar() {
    
    // Armazena no localStorage
    localStorage.setItem('examesSolicitados', JSON.stringify(listaExames));

    // Recupera o ID da consulta da URL atual (se presente)
    const urlParams = new URLSearchParams(window.location.search);
    const consultaId = urlParams.get('consulta_id');

    // Redireciona com o parâmetro consulta_id
    if (consultaId) {
        window.location.href = `editar-prontuario.php?consulta_id=${consultaId}`;
    } else {
        alert("ID da consulta não encontrado. Não foi possível voltar para o prontuário.");
    }
}
