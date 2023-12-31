# Docker + Laravel + Nginx + Postgres
Está imagem foi desenvolvida afim de facilitar a vida do desenvolvedor PHP, permitindo assim que de forma fácil um dev consiga executar todo o ambiente de desenvolvimento PHP. 

# Imagem Docker PHP com Nginx
[Ver imagem no Docker Hub](https://hub.docker.com/r/urnau/php-community)

# Ver Vídeo Passo a Passo
[Clique aqui para acessar o vídeo tutorial no YouTube](https://youtu.be/tm4WpxBai0w)
## Requisitos
- Ter o Docker instalando em sua máquina. Este passo a passo funciona tanto para ambiente Linux como para Windows e macOS.
- Caso você deseje subir uma imagem customizada para seu próprio Docker Hub é necessário então ter uma conta no [Docker Hub](https://hub.docker.com).


## Atenção
- Não execute os comandos de docker-compose build se este repositório estiver dentro de um subsistema Linux, como o WSL.

- Caso o comando `sh` não sirva para você executar os scripts, então experimente utilizar `./script-...`.


## 0º Passo
Clone este repositório para sua área de trabalho, pois iremos trabalhar a partir dessa estrutura de projeto.


## 1º Passo
Verificar se o Docker está sendo executado em sua máquina. 
Caso não esteja você deve iniciar o Docker, para isso basta basta:
- Abrir Docker Desktop, ou em ambiente Linux:
> sudo service docker start


## 2º Passo
Se você não for fazer `build` de uma nova imagem PHP + Nginx, então você pode pular para o `8º Passo`
Caso vá customizar sua imagem Docker, então acesse o arquivo [Dockerfile](./Dockerfile) e realize as alterações desejadas.


## 3º Passo
Depois de feiras as alteraçãoes agora vamos contruir a imagem. Para isso execute:
> docker-compose build web

Ou você pode executar diretamente o script:
> sh script-build-docker-compose.sh


## 4º Passo
Com a imagem criada corretamente, você agora pode fazer um teste de execução.
> docker run web


## 5º Passo
Se o teste de execução der certo, então é hora testarmos subir todo o ambiente do Docker Compose.
Para isso vamos executar agora
> docker-compose up -d

Ou você pode executar diretamente o script:
> sh script-start-docker-compose.sh

Quando quiser `parar` a execução desse ambiente execute:
> sh script-drop-docker-compose.sh


## 6º Passo
Estando tudo ok, agora é hora de subirmos a imagem para o Dockerhub, assim ela fica disponível para ser acessada em diversos ambientes.
É importante no `docker-compose.yml` ser alterado o nome da imagem para o de seu repositório.
Estando pronto, execute:
> sh script-push-docker-compose.sh

## 7º Passo
Devemos ir ao Docker Hub e verificar se nossa imagem já está corretamente em nosso repositório.

## 8º Passo
Agora é hora de ajustarmos nossas aplicações dentro do ambiente.

Para isso iremos usar a pasta `applications`, nela devemos salvar colocar cada projeto PHP, e é importante que cada projeto PHP tenha uma pasta `public`, pois é nestá pasta public que o Nginx irá consultar o index.php.

Assim, você pode clonar um projeto já existente dentro de `applications`, ou pode usar o script abaixo para gerar uma aplicação Laravel do zero. Certifique-se de ter o Composer e o PHP instalado em sua máquina para executar.
> sh script-new-project-laravel.sh

<b>OBS:</b> Para ajustar variaveis de conexão de banco de dados na sua aplicação veja exemplo: [index.php](./applications/php1/public/index.php).


## 9º Passo
Agora é hora de configurar o Nginx para que ele consiga encontrar suas aplicações.
Para isso execute:
> sh script-generate_sites.sh

Ao executar esse script, você deverá informar qual o nome da pasta de sua aplicação em `applications`. E também deverá informar uma porta que não esteja sendo utilizada no sistema. Recomendamos utilizar as portas entre 8080 e 8089.

## 10º Passo
Com todas essas configurações feitas, agora é hora de colocar a aplicação em execução.
> sh script-start-docker-compose.sh


Exemplo para acessar sua aplicação:
http://localhost:8080

## 11º Passo
Para derrubar a aplicação execute:
> sh script-drop-docker-compose.sh

## 12º Passo
Caso use Windows o macOS, agora é só mover todo o ambiente configurado aqui para dentro do WSL.

## Outras informações
- Caso precise remover as configuções de sites do Nginx, acesse a pasta docker/nginx/sites e lá encontre e remova as configurações `.conf` que desejar.

- Caso precise derrubar um container
> sh script-drop-container.sh


- Caso precise visualizar quais containers estão em execução
> sh script-docker-running.sh


- Caso precise entrar em um container
> sh script-access-container.sh


----------------------------------------------- 



# API Hotelaria

## Utilização do Projeto

```bash
  1. Clone esse projeto git@github.com:aziulll/Api-Hotelaria.git 

  2. Faça a instalação de um Ambiente de Desenvolvimento PHP

  2.2. Para testes em ambiente docker seguir em: 
  https://github.com/aziulll/Api-Hotelaria-docker

  3. Crie um DataBase chamado Hotelaria 

  Com base nas informações, lembre-se de configurar o 
  .env de acordo com as suas configurações no PostgreSQL

  DB_CONNECTION=pgsql
  DB_HOST=127.0.0.1
  DB_PORT=5432
  DB_DATABASE=hotelaria
  DB_USERNAME={seu_usuario_postgres}
  DB_PASSWORD={sua_senha_postgres}

```
    
## O que fazer antes de testar a API no Postman? 
```bash
   cd Api-Hotelaria
```
```bash
   code . (abrir no vs code)
```
```bash
   php artisan migrate
```
```bash
   php artisan serve
```

## Configurações no Postman: 

**Headers s/ auth**: 

```bash
Content-Type - application/json

Accept  - application/json

```

**Headers w/ auth**:

```bash
Content-Type - application/json

Accept  - application/json

Authorization - Bearer + Token 
```

(Bearer 1|TnfwI4aWlqvsZrNswywhL3yRxHWj072UbfJUl0CE7f6f0e26) - exemplo

OBS.: Esse token será gerado ao no Json de Autenticação de Usuário

## Realizar o consumo da API - **Cadastro de clientes**

   POST  /api/clientes/novo

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `nome, email, senha, telefone` | `string` | **Obrigatório**|

Exemplo que pode ser adicionado no Body: 

{

    "nome": "teste",
    "email": "teste@teste.com",
    "senha": "123456789",
    "telefone": "8023890"
}

Realizar o consumo da API - **Autenticação**


| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `email, senha` | `string` | **Obrigatório**|

{
    "email": "teste@teste.com",
    "senha": "123456789",
    "device_name": "teste"
}



## Documentação da API - Itens Obrigatórios 

*Autenticação é um fator determinante para conseguir acessas as próximas rotas*

#### Retorna uma lista de quartos disponíveis para reserva 

```http
  GET /api/quartos/disponivel
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `-` | `-` |- |



#### Encontra todos os quartos que estão ocupados em uma data específica

```http
  GET /api/quartos/ocupados
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `data_inicial, data_final`      | `date` | **Obrigatório**. A data da busca |

Exemplo:

{
    "data_inicial": "2023-08-20",
    "data_final": "2023-08-30"
}
#### Retorna todas as reservas do cliente

```http
  GET /api/reservas/{clienteId}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `ID`      | `number` | **Obrigatório**. Id do cliente|

## Melhorias

Melhorias aplicadas ao teste: 

- Cadastro de Reservas, Clientes e Quartos para retorno de testes manuais
- Autenticação do Cliente para acesso às rotas com o token gerado


## Consultas SQL 

Busca todos os quartos ocupados dentro da data especifica

```Bash
SELECT q.*
FROM quartos q
JOIN reservas r ON q.id = r.quarto_id
WHERE r.data_checkin <= '2023-08-20' 
  AND r.data_checkout >= '2023-08-30';
  AND q.disponivel = false;
  ```
## Stack utilizada

**Back-end:** Laravel, PostgreSQL
**Add**: Docker or Xampp
**Versões**: Php - 8.2, Laravel - 10, PostgreSQL - 16


