# CovidAPI
Prova de conceito em PHP/Lumen para consumir dados da API de COVID

# Endpoints

#### GET _[URL]/api/covid/casos/mensais_

Endpoint que internamente chama um serviço para obter os dados diários de casos confirmados de COVID no Brasil e agrupa por Ano/Mês.


#### GET _[URL]/_

Diretório raiz, que retorna uma view que carrega os dados retornados do endpoint _[URL]/api/covid/casos/mensais_

#### Execução

A maneira mais simples de execução é através da execução do servidor embutido no PHP. 
Porém pode ser executado em qualquer servidor que tenha suporte ao PHP na versão

`php -S localhost:8080 -t public`
