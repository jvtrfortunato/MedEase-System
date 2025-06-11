const listaExames = [];

// Carrega exames do localStorage ao abrir a página
document.addEventListener('DOMContentLoaded', function () {
    const examesSalvos = JSON.parse(localStorage.getItem('examesSolicitados'));
    if (examesSalvos && Array.isArray(examesSalvos)) {
        examesSalvos.forEach(exame => {
            adicionarExame(exame); // Adiciona cada exame à lista e à interface
        });
    }
});

function adicionarExame(nomeExame = null) {
    const select = document.getElementById('exame');
    const lista = document.getElementById('lista-exames');

    if (!nomeExame) nomeExame = select.value;

    if (nomeExame !== '') {
        // Evita duplicatas
        if (!listaExames.includes(nomeExame)) {
            listaExames.push(nomeExame);

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
                // Remove da lista
                const index = listaExames.indexOf(nomeExame);
                if (index !== -1) {
                    listaExames.splice(index, 1);
                }

                //Remove do DOM 
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

    // Redireciona para prontuario.php
    window.location.href = 'prontuario.php';
}


















// let exames = JSON.parse(localStorage.getItem('examesSolicitados')) || [];

// function adicionarExame() {
//     const select = document.getElementById('exame');
//     const valor = select.value;
//     if (valor && !exames.includes(valor)) {
//         exames.push(valor);
//         localStorage.setItem('examesSolicitados', JSON.stringify(exames));
//         atualizarLista();
//     }
// }

// function atualizarLista() {
//     const lista = document.getElementById('lista-exames');
//     lista.innerHTML = '';

//     exames.forEach((exame, index) => {
//         const container = document.createElement('div');
//         container.classList.add('exame-container');

//         const li = document.createElement('li');
//         li.classList.add('exame-item');
//         li.textContent = exame;

//         const imgRemover = document.createElement('img');
//         imgRemover.src = '../..//assets/img/lixeira.png';
//         imgRemover.alt = 'Lixeira';
//         imgRemover.classList.add('lixeira');
//         imgRemover.onclick = () => {
//         exames.splice(index, 1);
//         localStorage.setItem('examesSolicitados', JSON.stringify(exames));
//         atualizarLista();
//         };

//         container.appendChild(li);
//         container.appendChild(imgRemover);
//         lista.appendChild(container);
//     });
// }

// function finalizar() {
//     window.location.href = 'prontuario.php';
// }

// // Atualiza a lista ao carregar a página
// window.onload = atualizarLista;