//Script posologia
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

let medicamentos = [];

function adicionarMedicamento() {
    // Recupera o ID da prescrição da URL atual (se presente)
    const urlParams = new URLSearchParams(window.location.search);
    const idPrescricao = urlParams.get('prescricao_id');

    const principio = document.getElementById('principioAtivo');
    const concentracao = document.getElementById('concentracao');
    const forma = document.getElementById('forma');
    const via = document.getElementById('via');
    const tipoReceita = document.getElementById('tipoReceita');
    const intervaloInput = document.getElementById('input-intervalo');
    const frequenciaInput = document.getElementById('input-frequencia');
    const inicioTratamento = document.getElementById('inicioTratamento');
    const duracao = document.getElementById('duracao');
    const duracaoTipo = document.getElementById('duracaoTipo');

    // Pegar opção de intervalo selecionada
    const intervaloSelecionado = document.querySelector('#conteudo-intervalo .selecionado');
    const intervalo = intervaloSelecionado
        ? (intervaloSelecionado.tagName === 'INPUT'
            ? intervaloSelecionado.value.trim() + 'h'
            : intervaloSelecionado.textContent.trim())
        : '';

    // Pegar frequência e turno, se visíveis e preenchidos
    const frequencia = frequenciaInput?.value.trim() || '';
    const turnoSelecionado = document.querySelector('#conteudo-turno .selecionado');
    const turno = turnoSelecionado ? turnoSelecionado.textContent.trim() : '';

    // Verifica se campos obrigatórios estão preenchidos
    if (!principio || !concentracao || !forma || !via || !tipoReceita || !inicioTratamento || !duracao) {
        alert('Preencha todos os campos obrigatórios do medicamento.');
        return;
    }

    // Validação: apenas UM entre frequência, intervalo e turno deve estar preenchido
    const preenchidos = [frequencia, intervalo, turno].filter(valor => valor !== '');

    if (preenchidos.length !== 1) {
        alert('Preencha apenas um dos campos: Frequência, Intervalo ou Turno.');
        return;
    }

    // Criar objeto com os dados
    const medicamento = {
        id_medicamento: 0,
        nome_medicamento: principio.value.trim(),
        concentracao: concentracao.value.trim(),
        forma_farmaceutica: forma.value.trim(),
        via_administracao: via.value.trim(),
        tipo_receita: tipoReceita.value.trim(),
        intervalo_dose: intervalo,
        frequencia_dose: frequencia,
        turno_dose: turno,
        data_inicio: inicioTratamento.value.trim(),
        quantidade_duracao: duracao.value.trim(),
        tipo_duracao: duracaoTipo.value.trim(), 
        id_prescricao: idPrescricao
    };

    medicamentos.push(medicamento);
    atualizarListaMedicamentos();
    limparCampos();
}

function atualizarListaMedicamentos() {
    const lista = document.getElementById('listaMedicamentos');
    lista.innerHTML = ''; // Limpa a lista antes de atualizar

    medicamentos.forEach((medicamento, index) => {

        const container = document.createElement('div');
        container.classList.add('item-lista');

        const li = document.createElement('li');

        // Botão de excluir (imagem)
        const imgRemover = document.createElement('img');
        imgRemover.src = '../../assets/img/lixeira.png'; 
        imgRemover.alt = 'Excluir';
        imgRemover.title = 'Excluir';
        imgRemover.className = 'lixeira';
        imgRemover.addEventListener('click', () => excluirMedicamento(index));

        li.textContent = `${index + 1}. ${medicamento.nome_medicamento}`;
    
        container.appendChild(li);
        container.appendChild(imgRemover);
        lista.appendChild(container);
    });
}

function limparCampos() {
    document.getElementById('principioAtivo').value = '';
    document.getElementById('concentracao').value = '';
    document.getElementById('forma').value = '';
    document.getElementById('via').value = '';
    document.getElementById('tipoReceita').value = '';
    document.getElementById('inicioTratamento').value = '';
    document.getElementById('duracao').value = '';
    document.getElementById('input-intervalo').value = '';
    document.getElementById('input-frequencia').value = '';

    // Remove seleção dos botões de intervalo e turno
    const botoesSelecionados = document.querySelectorAll('.opcao-selecionavel.selecionado');
    botoesSelecionados.forEach(botao => botao.classList.remove('selecionado'));
}

function excluirMedicamento(index) {
    medicamentos.splice(index, 1); // remove do array
    atualizarListaMedicamentos();  // atualiza a interface
}

//Envia os remedios e as recomendações para o prontuario.php
document.getElementById('botaoSalvarPrescricao').addEventListener('click', () => {
    const recomendacoes = document.getElementById('recomendacoes').value.trim();

    // Salva no localStorage
    localStorage.setItem('medicamentosPrescricao', JSON.stringify(medicamentos));
    localStorage.setItem('recomendacoesPrescricao', recomendacoes);

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

//Restaura os dados quando voltar para editar-prescricao.php
window.addEventListener('DOMContentLoaded', () => {
    const dadosMedicamentos = localStorage.getItem('medicamentosPrescricao');
    const dadosRecomendacoes = localStorage.getItem('recomendacoesPrescricao');

    if (dadosMedicamentos) {
        medicamentos = JSON.parse(dadosMedicamentos);
        console.log("Medicamentos carregados do localStorage:", medicamentos);
        atualizarListaMedicamentos(); // já deve existir essa função no seu script
    }

    if (dadosRecomendacoes) {
        console.log("Recomendações carregadas do localStorage:", dadosRecomendacoes);
        document.getElementById('recomendacoes').value = dadosRecomendacoes;
    }
});

//Envia os dados para gerar-prescricao.php
document.getElementById('botaoImprimirPrescricao').addEventListener('click', () => {
    const medicamentosJSON  = JSON.stringify(medicamentos); // array global
    const recomendacoes = document.getElementById('recomendacoes').value.trim();

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'gerar-prescricao-editar.php';
    form.target = '_blank'; // abrir em nova aba

    const input1 = document.createElement('input');
    input1.type = 'hidden';
    input1.name = 'medicamentos';
    input1.value = medicamentosJSON;

    const input2 = document.createElement('input');
    input2.type = 'hidden';
    input2.name = 'recomendacoes';
    input2.value = recomendacoes;

    form.appendChild(input1);
    form.appendChild(input2);
    document.body.appendChild(form);
    form.submit();
    form.remove();
});
