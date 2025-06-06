<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Exames</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/solicitar-exames.css">
</head>
<body>
    <header>
        <a class="logo" href="">MedEase</a>    
        <a href="">sair</a>
    </header>
    <main>
        <h1 class="titulo_secao">Solicitação de Exame</h1>
        <section class="descricao_exame">
            <section class="nome_exame">
                <form action="">
                    <label for="">Exame</label>
                    <select name="" id="exame">
                        <option value="">Selecione um exame</option>
                        <option value="RAIO-X">RAIO-X</option>
                        <option value="HEMOGRAMA">HEMOGRAMA</option>
                        <option value="RESSONÂNCIA">RESSONÂNCIA</option>
                    </select>
                </form>
            </section>
            <section class="nome_medico">
                <div>
                    <button onclick="adicionarExame()">Confirmar</button>
                </div>
            </section>
        </section>
        <h1 class="titulo_secao">Exames solicitados</h1>
        <section class="todos_exames_solicitados">
            <div class="conteudo_exames_solicitados">
                <p class="titulo">Nome do exame</p>
                <div class="barra_separacao"></div>
                <ul id="lista-exames"></ul>
            </div>
        </section>
        <div class="botao">
            <button onclick="finalizar()">Finalizar</button>
        </div>
    </main>
    
    <footer></footer>
    
    <script>
        let exames = JSON.parse(localStorage.getItem('examesSolicitados')) || [];

        function adicionarExame() {
            const select = document.getElementById('exame');
            const valor = select.value;
            if (valor && !exames.includes(valor)) {
                exames.push(valor);
                localStorage.setItem('examesSolicitados', JSON.stringify(exames));
                atualizarLista();
            }
        }

        function atualizarLista() {
            const lista = document.getElementById('lista-exames');
            lista.innerHTML = '';

            exames.forEach((exame, index) => {
                const container = document.createElement('div');
                container.classList.add('exame-container');

                const li = document.createElement('li');
                li.classList.add('exame-item');
                li.textContent = exame;

                const imgRemover = document.createElement('img');
                imgRemover.src = '/assets/img/lixeira.png';
                imgRemover.alt = 'Lixeira';
                imgRemover.classList.add('lixeira');
                imgRemover.onclick = () => {
                exames.splice(index, 1);
                localStorage.setItem('examesSolicitados', JSON.stringify(exames));
                atualizarLista();
                };

                container.appendChild(li);
                container.appendChild(imgRemover);
                lista.appendChild(container);
            });
        }

        function finalizar() {
            window.location.href = 'prontuario.php';
        }

        // Atualiza a lista ao carregar a página
        window.onload = atualizarLista;
    </script>
</body>
</html>