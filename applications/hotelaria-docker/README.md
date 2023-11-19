
# API Hotelaria





## Utilização do Projeto

```bash
  1. Clone esse projeto https://github.com/aziulll/Api-Hotelaria.git 

  2. Faça a instalação de um Ambiente de Desenvolvimento PHP

  2.2. Para testes em ambiente docker seguir em: 
  https://github.com/aziulll/Api-Hotelaria-docker

  2.3 Para testes em Xampp:
  Verificar essa configuração no arquivo xampp/php/php.ini. 
  As duas linhas a seguir devem estar sem comentários:

  extension=pdo_pgsql
  extension=pgsql

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
    
## O que fazer no terminal antes de testar a API no Postman? 
Abra o projeto 
```bash
   cd Api-Hotelaria
```
Crie o Arquivo .env
```bash
cp .env.example .env
```
Abrir no vscode 
```bash
   code .
```
```bash
   php artisan migrate
```
```bash
   php artisan serve
```

## Configurações no Postman: 

**Headers para rotas sem auth**: 

```bash
Content-Type - application/json

Accept  - application/json

```

**Headers para rotas com auth**:

```bash
Content-Type - application/json

Accept  - application/json

Authorization - Bearer + Token 
```

(Bearer 1|TnfwI4aWlqvsZrNswywhL3yRxHWj072UbfJUl0CE7f6f0e26) - exemplo

OBS.: Esse token será gerado no Json de Autenticação de Usuário

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

## Realizar o consumo da API - **Autenticação**


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
  ```
## Stack utilizada

**Back-end:** Laravel, PostgreSQL
**Add**: Docker or Xampp
**Versões**: Php - 8.2, Laravel - 10, PostgreSQL - 16

