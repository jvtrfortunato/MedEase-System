//Função para alternar entre as labels Intervalo, Frequência e Turno
function alternarLabels(tipo) {
    // Remove a classe 'ativo' de todos os labels
    document.querySelectorAll('.labels label').forEach(label => {
    label.classList.remove('ativo');
    });

    // Adiciona classe 'ativo' ao label clicado
    document.getElementById('label-' + tipo).classList.add('ativo');

    // Esconde todas as divs
    document.querySelectorAll('.frequencia-detalhe').forEach(div => {
    div.classList.remove('visivel');
    });

    // Mostra a div correspondente
    document.getElementById('conteudo-' + tipo).classList.add('visivel');
}

//Função para alternar entre as opções das labels Intervalo e Turno
function selecionarOpcao(elemento) {
    // Remove a seleção de todos os elementos selecionáveis
    const todasAsOpcoes = document.querySelectorAll('.opcao-selecionavel');
    todasAsOpcoes.forEach(op => op.classList.remove('selecionado'));

    // Limpa os inputs manuais
    const inputs = document.querySelectorAll('.opcao-selecionavel[type="text"], .opcao-selecionavel[type="number"]');
    inputs.forEach(input => input.value = '');

    // Marca o elemento clicado ou focado como selecionado
    elemento.classList.add('selecionado');
}

//Função para atualizar a lista de medicamentos
function atualizarListaMedicamentos() {
    const lista = document.getElementById('listaMedicamentos');
    lista.innerHTML = ''; // Limpa a lista antes de atualizar

    nomesMedicamentos.forEach((nome, index) => {
        const container = document.createElement('div');
        container.classList.add('item-lista');

        const li = document.createElement('li');
        li.textContent = `${index + 1}. ${nome}`;

        container.addEventListener('click', () => {
            // Remove a classe 'ativa' de todos os containers
            document.querySelectorAll('.item-lista').forEach(el => {
                el.classList.remove('ativa');
            });

            // Adiciona a classe 'ativa' apenas à div clicada
            container.classList.add('ativa');

            // Chama a função de exibição dos dados
            exibirDetalhesMedicamento(index);
        });
    
        container.appendChild(li);
        lista.appendChild(container);

        // Se for o primeiro item, ativa automaticamente
        if (index === 0) {
            container.classList.add('ativa');
        }
    });

    // Exibe os detalhes do primeiro medicamento ao carregar a página
    if (medicamentos.length > 0) {
        exibirDetalhesMedicamento(0);
    }
}

//Função para exibir os dados do medicamento selecionado
function exibirDetalhesMedicamento(index) {
    //função para formatar a data
    function formatarData(isoDate) {
        if (!isoDate) return '';
        const partes = isoDate.split('-'); // ["2025", "06", "14"]
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
    }

    const medicamento = medicamentos[index];

    document.getElementById('input-principioAtivo').textContent = medicamento.principioAtivo;
    document.getElementById('input-concentracao').textContent = medicamento.concentracao;
    document.getElementById('input-forma').textContent = medicamento.formaFarmaceutica;
    document.getElementById('input-via').textContent = medicamento.viaAdministracao;
    document.getElementById('input-tipo-receita').textContent = medicamento.tipoReceita;
    if(medicamento.intervaloDose) {
        document.getElementById('input-posologia').textContent = 'A cada ' + medicamento.intervaloDose + '.';
    }
    if(medicamento.frequenciaDose) {
        document.getElementById('input-posologia').textContent = medicamento.frequenciaDose;
    }
    if(medicamento.turnoDose) {
        document.getElementById('input-posologia').textContent = 'Todas as ' + medicamento.turnoDose + '.';
    }
    document.getElementById('input-inicio').textContent = formatarData(medicamento.inicioTratamento);
    document.getElementById('input-duracao').textContent = medicamento.quantidadeDuracao + ' ' + medicamento.tipoDuracao;
}
