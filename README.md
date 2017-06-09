# ZF3-API
Estou portando uma parte deste projeto https://github.com/MatheusSilva/zendphptecinfo para o Zend FrameWork 3 em forma de Api RestFull 

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
 curl -d "login=ze&nome=zezinho&email=zezinhoasdxsdd@gmail.com&telefone=(95) 2757-4164&endereco=Rua José Batista de Souza" -v -X POST http://192.168.33.10:8080/api/user

Detalhe de um usuário
 curl -v -X GET http://192.168.33.10:8080/api/user/4

Atualizando um usuário
 curl -d "login=matheus&nome=matheus silva&email=matheus.hahhgdgf@gmail.com&telefone=987956475&endereco=Numa quebrada loka" -v -X PUT http://192.168.33.10:8080/api/user/4

Excluindo um usuário
 curl -v -X DELETE http://192.168.33.10:8080/api/user/4
```


## Categoria

```
Listando todas Categorias
 curl -v -X GET http://192.168.33.10:8080/api/categoria

Adicionando uma nova Categoria
 curl -d "nome=zezinho" -v -X POST http://192.168.33.10:8080/api/categoria

Detalhe da Categoria
 curl -v -X GET http://192.168.33.10:8080/api/categoria/10

Atualizando uma Categoria
 curl -d "nome=sub 300" -v -X PUT http://192.168.33.10:8080/api/categoria/10

Excluindo uma Categoria
 curl -v -X DELETE http://192.168.33.10:8080/api/categoria/11
```

## Divisão

```
Listando todas Divisões
 curl -v -X GET http://192.168.33.10:8080/api/divisao

Adicionando uma nova Divisão
 curl -d "nome=segundona" -v -X POST http://192.168.33.10:8080/api/divisao

Detalhe da Divisão
 curl -v -X GET http://192.168.33.10:8080/api/divisao/4

Atualizando uma Divisão
 curl -d "nome=serie C" -v -X PUT http://192.168.33.10:8080/api/divisao/4

Excluindo uma Divisão
 curl -v -X DELETE http://192.168.33.10:8080/api/divisao/4
```

## Técnico

```
Listando todos Técnicos
 curl -v -X GET http://192.168.33.10:8080/api/tecnico

Adicionando um novo Técnico
 curl -d "nome=tite&data_nascimento=20/04/1985" -v -X POST http://192.168.33.10:8080/api/tecnico

Detalhe do Técnico
 curl -v -X GET http://192.168.33.10:8080/api/tecnico/4

Atualizando um Técnico
 curl -d "nome=renato C&data_nascimento=25/02/1980" -v -X PUT http://192.168.33.10:8080/api/tecnico/4

Excluindo um Técnico
 curl -v -X DELETE http://192.168.33.10:8080/api/tecnico/4
```

## Time

```
Listando todos Times
 curl -v -X GET http://192.168.33.10:8080/api/time

Adicionando um novo Time
 curl -d "nome=inter&tecnico_codigo_tecnico=5&categoria_codigo_categoria=10&divisao_codigo_divisao=4&desempenho_time=0&comprar_novo_jogador=0&capa=foto.png" -v -X POST http://192.168.33.10:8080/api/time/create

Detalhe do Time
 curl -v -X GET http://192.168.33.10:8080/api/time/detalhe/2

Atualizando um Time
 curl -d "nome=ceramica&tecnico_codigo_tecnico=5&categoria_codigo_categoria=10&divisao_codigo_divisao=4&desempenho_time=0&comprar_novo_jogador=0&capa=foto.png" -v -X POST http://192.168.33.10:8080/api/time/update/2

Excluindo um Time
 curl -v -X DELETE http://192.168.33.10:8080/api/time/delete/2
```

Meu perfil no linkedin(http://br.linkedin.com/in/matheussilvaphp)
