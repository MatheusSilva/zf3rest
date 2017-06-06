# ZF3-API
Estou portando uma parte deste projeto https://github.com/MatheusSilva/laravel-api para o Zend FrameWork 3 em forma de Api RestFull 

## Arquivo para criar o banco de dados

```
	data/schema.sql
	Em caso de problemas na aplicação excluir todos arquivos menos .gitkeep no diretorio data/cache
```

## testando APIs REST usando cURL

```
Uma das várias vantagens das APIs é que eu posso testar a API sem codificar uma linha sequer da interface(html,css e javascript) somente usando a ferramenta cURL no terminal linux/windows/mac ou da também para utilizar um extensão no navegador que faz isto. 

Listando todos os usuários
 curl -v -X GET http://192.168.33.10:8080/api/user

Adicionando um novo usuário
 curl -d "login=reyan&nome=Reyansh Beemineni&email=reyan@gmail.com&telefone=9448985881&endereco=Sai Smaran Apartment, Bangalore" -v -X POST http://192.168.33.10:8080/api/user

Detalhe de um usuário
 curl -v -X GET http://192.168.33.10:8080/api/user/1

Atualizando um usuário
 curl -d "login=matheus&nome=matheus silva&email=matheus.hahhgdgf@gmail.com&telefone=987956475&endereco=Numa quebrada loka" -v -X PUT http://192.168.33.10:8080/api/user/4

Excluindo um usuário
 curl -v -X DELETE http://192.168.33.10:8080/api/user/4
```

Meu perfil no linkedin(http://br.linkedin.com/in/matheussilvaphp)
