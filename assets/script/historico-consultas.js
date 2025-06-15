let tipoAtual = 'todos'; 

function mostrar(tipo){
    tipoAtual = tipo;
    // Esconde ambas as filtros
    document.getElementById('todos').classList.add('oculto');
    document.getElementById('medicos').classList.add('oculto');
    document.getElementById('pacientes').classList.add('oculto');

    // Remove o destaque dos botões
    document.getElementById('opcao-todos').classList.remove('ativo');
    document.getElementById('opcao-medico').classList.remove('ativo');
    document.getElementById('opcao-paciente').classList.remove('ativo');

    // Limpa inputs ao trocar de filtro
    if (inputMedico) inputMedico.value = '';
    if (inputPaciente) inputPaciente.value = '';

    if (tipo === 'todos') {
        document.getElementById('todos').classList.remove('oculto');
        document.getElementById('opcao-todos').classList.add('ativo');

        // Ordena por mais recentes e exibe
        const consultasOrdenadas = ordenarConsultas(consultas, 'recentes');
        renderizarConsultas(consultasOrdenadas);

    } else if (tipo === 'medico') {
        document.getElementById('medicos').classList.remove('oculto');
        document.getElementById('opcao-medico').classList.add('ativo');

    } else {
        document.getElementById('pacientes').classList.remove('oculto');
        document.getElementById('opcao-paciente').classList.add('ativo');
    }           
}

// Exemplo: listando os títulos
consultas.forEach(c => {
    console.log('Consulta:', c.title, 'Paciente:', c.nome_paciente, 'Médico:', c.nome_medico);
});

function renderizarConsultas(consultasFiltradas) {
    const lista = document.getElementById('lista-consultas');
    lista.innerHTML = ''; // Limpa a lista antes de inserir novos itens

    if (consultasFiltradas.length === 0) {
        lista.innerHTML = '<p>Nenhuma consulta encontrada.</p>';
        return;
    }

    consultasFiltradas.forEach(consulta => {
        const item = document.createElement('section');
        item.classList.add('legenda');

        item.innerHTML = `
            <div class="legenda-paciente-medico">
                <div class="legenda-paciente">
                    <div class="paciente">
                        <p>${consulta.nome_paciente}</p>
                    </div>
                </div>
                <div class="legenda-data">
                    <div class="data">
                        <p>${formatarData(consulta.start)}</p>
                    </div>
                </div>
                <div class="legenda-medico">
                    <div class="medico">
                        <p>${consulta.nome_medico}</p>
                    </div>
                </div>
            </div>

            <div class="legenda-prontuario">
                <a href="editar-prontuario.php?consulta_id=${consulta.id}" class="prontuario">
                    Abrir Prontuário
                </a>
            </div>
        `;

        lista.appendChild(item);
    });
}

function formatarData(dataIso) {
    const data = new Date(dataIso);
    return data.toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

//Filtro por nome de médico
const inputMedico = document.getElementById('input-medico');

inputMedico.addEventListener('input', function () {
    const termo = this.value.toLowerCase();

    const filtradas = consultas.filter(c => 
        c.nome_medico.toLowerCase().includes(termo)
    );

    renderizarConsultas(filtradas);
});

//Filtro por nome de paciente
const inputPaciente = document.getElementById('input-paciente');

inputPaciente.addEventListener('input', function () {
    const termo = this.value.toLowerCase();

    const filtradas = consultas.filter(c => 
        c.nome_paciente.toLowerCase().includes(termo)
    );

    renderizarConsultas(filtradas);
});

// Ordenação por data no filtro Todos
const ordenacaoTodos = document.getElementById('ordenacao-todos');

ordenacaoTodos.addEventListener('change', function () {
    const ordem = this.value;

    // Cópia do array para evitar modificar o original
    let consultasOrdenadas = [...consultas];

    consultasOrdenadas.sort((a, b) => {
        const dataA = new Date(a.start);
        const dataB = new Date(b.start);

        return ordem === 'recentes'
            ? dataB - dataA // mais recentes primeiro
            : dataA - dataB; // mais antigas primeiro
    });

    renderizarConsultas(consultasOrdenadas);
});

//Fução reutilizável
function ordenarConsultas(array, ordem) {
    return [...array].sort((a, b) => {
        const dataA = new Date(a.start);
        const dataB = new Date(b.start);

        return ordem === 'recentes' ? dataB - dataA : dataA - dataB;
    });
}

// Ordenação por data no filtro Médicos
const selectMedico = document.getElementById('ordenacao-medico');

function filtrarMedicos() {
    const termo = inputMedico.value.toLowerCase();
    const ordem = selectMedico.value;

    const filtradas = consultas.filter(c =>
        c.nome_medico.toLowerCase().includes(termo)
    );

    const ordenadas = ordenarConsultas(filtradas, ordem);
    renderizarConsultas(ordenadas);
}

inputMedico.addEventListener('input', filtrarMedicos);
selectMedico.addEventListener('change', filtrarMedicos);

// Ordenação por data no filtro Pacientes
const selectPaciente = document.getElementById('ordenacao-paciente');

function filtrarPacientes() {
    const termo = inputPaciente.value.toLowerCase();
    const ordem = selectPaciente.value;

    const filtradas = consultas.filter(c =>
        c.nome_paciente.toLowerCase().includes(termo)
    );

    const ordenadas = ordenarConsultas(filtradas, ordem);
    renderizarConsultas(ordenadas);
}

inputPaciente.addEventListener('input', filtrarPacientes);
selectPaciente.addEventListener('change', filtrarPacientes);

//Padrão ao carregar a página
document.addEventListener('DOMContentLoaded', function () {
    const consultasOrdenadas = ordenarConsultas(consultas, 'recentes');
    renderizarConsultas(consultasOrdenadas);
});

//Função para voltar para atendimentos do dia
const voltarPagina = document.getElementById("voltarPagina");

if (voltarPagina) {
    voltarPagina.addEventListener("click", () => {

        window.location.href = "../../app/views/relatorios.php";
    });
}