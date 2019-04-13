# Teste Web e Api

## Requisitos
- Docker instalado
- Composer instalados

## Rodar com Docker
- clonar projeto
- navegar até pasta raiz do projeto via bash
- executar: composer install
- executar: mv env-example .env
- executar: docker-compose up -d
- em caso de primeiro criação das máquinas, realizar agora o passo "Usuando Docker: Primeira Configuração BD"
- acessar maquina web: docker exec -it web_app bash
- executar dentro da maquina web: php artisan key:generate
- executar dentro da maquina web: php artisan migrate:fresh --seed
- sair da maquina: exit;

## Docker: Primeira Configuração BD
- acessar maquina do BD: docker exec -it web_mysql bash
- logar com usuario do mysql: mysql -u root -p
- usar senha conforme setado no docker-compose: rootpass
- criar usuario para mysql: CREATE USER 'userdb'@'testedb' IDENTIFIED BY 'passdb';
- liberar permissões para usuario: GRANT ALL PRIVILEGES ON * . * TO 'userdb'@'testedb';
- recarregar as permissões: FLUSH PRIVILEGES;
- sair da maquina: exit;

## Testes unitários
- Acessar pasta da aplicação via bash
- Executar comando "docker-compose build" para criar as imagens dos containers caso não tenha sido feito no passo anterior
- Executar comando "docker-compose up -d" para iniciar os containers
- Executar comando "docker exec -it web_app bash" para acessar o container da aplicação no modo interativo ("web_app" é nome setado no docker-compose.yml)
- Na raiz do projeto, executar o comando "vendor/bin/phpunit" para rodar a suite de teste
- Ao final executar comando "exit" para sair do container e executar comando "docker-compose down" para encerrar os containers


## Observações Importantes
- Projeto estará acessível via browser / bash somente após finalizada instalação e/ou atualização das dependências do framework
- Para acessar qualquer container iniciado no modo interativo devemos usar comando "docker exec -it NOME_OU_ID_CONTAINER bash"
- Para execução do modo interativo via bash existe uma limitação em ambiente Windows ("cannot enable tty mode on non tty input"), que força o camando ser iniciado com "winpty" ficando desta forma: "winpty docker exec -it NOME_OU_ID_CONTAINER bash"
