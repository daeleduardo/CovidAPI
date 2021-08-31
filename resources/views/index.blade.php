<!DOCTYPE html>
<html>

<head>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.7.2/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.2/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.2/dist/js/uikit-icons.min.js"></script>
</head>

<body onload="carregarDados()">
    <div id="msg" class="uk-flex uk-flex-column uk-align-center uk-text-center">
        <div class="uk-card uk-card-default uk-card-body">
            <span class="uk-label">Aguarde...</span>
        </div>
        <div class="uk-card uk-card-default uk-card-body">
            <div uk-spinner></div>
        </div>
    </div>

    <div id="conteudo" class="uk-invisible"></div>
</body>
<script>
    function carregarDados() {
        setTimeout(function() {
            buscarCasosConfirmados();
        }, 500);
    }

    function buscarCasosConfirmados() {
        fetch(`http://${window.location.host}/api/covid/casos/mensais`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(json => preencherTabela("conteudo", json.data, ocultarSpinner()))
            .catch(err => console.log('Erro ao fazer requisição', err));

    }

    //Oculta a informacao de carregamento
    function ocultarSpinner() {
        const msg = document.getElementById("msg");
        const conteudo = document.getElementById("conteudo");
        msg.classList.add("uk-hidden");
        conteudo.classList.remove("uk-invisible");
    }

    //Cria a tabela na tela
    function criarTabela(id) {

        const tabela = document.getElementById(id).querySelector("table");

        if (tabela !== null) {
            tabela.innerHTML = "";
            return;
        }

        const conteudo = document.getElementById(id);
        conteudo.innerHTML = "";
        const novaTabela = document.createElement("table");
        novaTabela.classList.add("uk-table");
        novaTabela.classList.add("uk-table-striped");
        novaTabela.classList.add("uk-table-hover");
        novaTabela.classList.add("uk-table-small");
        conteudo.appendChild(novaTabela);
    }

    //Preenche as linhas da tabela
    function preencherLinhas(id, data) {
        const tabela = document.getElementById(id).querySelector("table");
        //Conta o número de campos existentes
        const colunas = Object.keys(data[0]);

        //Preenche com os dados
        data.forEach(item => {
            const tr = document.createElement("tr");
            colunas.forEach(coluna => {
                const td = document.createElement("td");
                td.innerText = item[coluna];
                tr.appendChild(td);
            });
            tabela.appendChild(tr);
        });
    }

    //Preenche o cabeçalho da tabela
    function preencherCabecalho(id, data) {

        const tabela = document.getElementById(id).querySelector("table");

        const tr = document.createElement("tr");
        const colunas = Object.keys(data[0]);
        for (const coluna in colunas) {
            const td = document.createElement("td");
            td.innerText = colunas[coluna];
            tr.appendChild(td);
        }

        tabela.appendChild(tr);

    }

    //Preenche a tabela
    function preencherTabela(id, data) {
        criarTabela(id);
        preencherCabecalho(id, data);
        preencherLinhas(id, data);
    }
</script>

</html>