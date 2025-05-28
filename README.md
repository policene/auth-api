# Como rodar?
Primeiro baixe ou clone o projeto. Depois abra a pasta auth-api, e digite o seguinte comando:
````powershell
# Comando do Docker-Compose
docker-compose up --build
````

Após isso, ele vai subir a API PHP com todas as dependências instaladas, junto com serviços do PostgreSQL e Redis. Caso dê algum erro, provavelmente uma das seguinte portas do seu localhost já estão ocupadas: 8000, 6379 ou 5433. Se for o caso, ou você "mata" os processos que estão usando essa porta, ou você altera as portas no arquivo docker-compose.yaml.
<br>
<br>

# Endpoints

## [POST] /user
Faz a criação de um novo usuário no sistema e armazena na tabela 'users.'
### URL:
```
localhost:8000/user
```
### Body esperado:
``` json
{
    "name": "Nome",
    "lastName": "Sobrenome",
    "email": "emailteste@gmail.com",
    "password": "senha"
}
```
### Response esperada:
``` json
{
    "msg": "ok",
    "user": {
        "name": "Nome",
        "lastName": "Sobrenome",
        "email": "emailteste@gmail.com",
        "password": "$2y$12$x0X3kRIb/36DNZjTCubyKOvOgfdFyQNq0XEDpcahgOGZnDDHej1JW" // Hash da senha
    }
}
```
<br>

## [GET] /user
Faz a busca de um usuário passando como query string o email a ser usado como parâmetro.
### URL:
```
localhost:8000/user?email=emailteste@gmail.com
```
### Response esperada:
``` json
{
    "name": "Nome",
    "lastName": "Sobrenome",
    "email": "emailteste@gmail.com",
    "password": "$2y$12$x0X3kRIb/36DNZjTCubyKOvOgfdFyQNq0XEDpcahgOGZnDDHej1JW" // Hash da senha
}
```
<br>

## [POST] /token
Gera um token JWT caso o usuário faça login corretamente.
### URL:
```
localhost:8000/token
```
### Body esperado:
``` json
{
    "email": "emailteste@gmail.com",
    "password": "senha"
}
```
### Response esperada:
``` json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImlicmFlbHRhc3NhdGVzdGVAZ21haWwuY29tIiwiaWF0IjoxNzQ4NDQ0MDU0LCJleHAiOjE3NDg0NDc2NTR9.1EmAjrx4AWQlsgXOQEXZ07vHooocUFcpHNeZx9p9K7A" // Token de exemplo
}
```
<br>

## [GET] /token
Recebe um ID de usuário como query string e um token JWT no header da requisição, e com base nessas informações retorna se o usuário dono do ID passado está autenticado ou não.
### URL:
```
localhost:8000/token?id=1
```
### Header
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImlicmFlbHRhc3NhdGVzdGVAZ21haWwuY29tIiwiaWF0IjoxNzQ4NDQ0MDU0LCJleHAiOjE3NDg0NDc2NTR9.1EmAjrx4AWQlsgXOQEXZ07vHooocUFcpHNeZx9p9K7A
```
### Response esperada:
``` json
{
    "auth": true
}
```
