ROTEIRO DO PROJETO DA DISCPLINA PHP - RESIDÊNCIA

SYMFONY

Setup

PHP v.8.1.14
Comando: php -v

PHP 8.1.14 (cli) (built: Jan  4 2023 12:24:57) (NTS Visual C++ 2019 x64)
Copyright (c) The PHP Group
Zend Engine v4.1.14, Copyright (c) Zend Technologies

Composer 2.5.1
Comando: composer -V
Composer version 2.5.1 

Symfony 5.4.20
Comando: symfony self:version
Symfony CLI version 5.4.20 (c) 2021-2023 Fabien Potencier

Passo a passo da criação do projeto:

- symfony new Avaliacao --version="6.1.*" - Criação da pasta com a estrutura do projeto symfony;
- symfony server:start: inicializa o projeto no servidor; gerando http://127.0.0.1:8000;
 
- composer require symfony/runtime

- composer require security

Rotas com ANNOTATION:
- composer required annotation

TWIG:
- composer required twig

Doctrines:
- composer require symfony/maker-bundle symfony/orm-pack

BANCO DE DADOS COM DOCKER

- Editar o documento docker-composer.yml dentro da pasta do projeto
com as seguintes configurações:
	
	version: '3.8'
	services:
  		mysql:
    		image: mariadb:10.8.3
    		command: --default-authentication-plugin=mysql_native_password
    		restart: always
    	environment:
      	MYSQL_ROOT_PASSWORD: root
    		ports:
      		- 3306:3306
  	adminer:
    	image: adminer
    	restart: always
   	 ports:
      	- 8080:8080

- Editar o DATABASE_URL no arquivo .env para:

DATABASE_URL="mysql://root:root@127.0.0.1:3306/projeto? serverVersion=mariadb-10.8.3&charset=utf8mb4", em projeto colocar o nome do projeto que esta sendo trabalhado e em root:root será o usuario:senha

- Excluir arquivo docker-compose.override.yaml caso exista

- Criar container docker: - docker compose up
- Startar o container no app docker desktop;

CRIAÇÃO DO BANCO DE DADOS;
- symfony console doctrine:database:create
- Criando tebela de Agências: - symfony console make:entity
EXEMPLO: Entity: Agencia;
	      propertys: nome, endereco, telefone, email;
obs.: feito dessa maneira para todas as entitys
- Criar tabela no container: - symfony console make:migration
- Executando migration: - symfony console doctrine:migrations:migrate

Verificando o CRUD no navegador:
http://127.0.0.1:8000
localhost:8080 para acesso ao MYSQL com o bando de dados e tabelas;
Após criada as entitys, gerar também os controllers atraves do comando: - symfony console make: controller;
Fazer a authenticação com o comando make:auth 

Links de documentação consultados:

https://symfony.com/doc/current/doctrine.html
https://symfony.com/doc/current/doctrine/associations.html
https://www.binaryboxtuts.com/php-tutorials/symfony-5-crud-app-easy-tutorial/
https://symfony.com/doc/5.2/security/form_login_setup.html
https://symfony.com/doc/5.2/components/security/authorization.html#roles
