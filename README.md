# Teste Web e Api

## Requisitos
- Docker instalado
- Git bash instalado


## Executar projeto
- Acessar pasta da aplicação via git bash
- Executar comando "docker-compose build" para criar as imagens dos containers
- Executar comando "docker-compose up -d" para iniciar os containers
- Abrir a aplicação no endereço "http://localhost:8080/"
- Ao final dos testes acessar pasta da aplicação via git bash e executar comando "docker-compose down" para encerrar os containers


## Testes unitários
- Acessar pasta da aplicação via git bash
- Executar comando "docker-compose build" para criar as imagens dos containers caso não tenha sido feito no passo anterior
- Executar comando "docker-compose up -d" para iniciar os containers
- Executar comando "docker exec -it web_app bash" para acessar o container da aplicação no modo interativo ("web_app" é nome setado no docker-compose.yml)
- Na raiz do projeto, executar o comando "vendor/bin/phpunit" para rodar a suite de teste
- Ao final executar comando "exit" para sair do container e executar comando "docker-compose down" para encerrar os containers


## Observações Importantes
- Projeto estará acessível via browser / bash somente após finalizada instalação e/ou atualização das dependências do framework
- Primeira execução dos comando de "build" e "up" poderá ser demorada, variando entre 5 a 15 minutos dependendo da rede disponível
- Para acessar qualquer container iniciado no modo interativo devemos usar comando "docker exec -it NOME_OU_ID_CONTAINER bash"
- Para execução do modo interativo via bash existe uma limitação em ambiente Windows ("cannot enable tty mode on non tty input"), que força o camando ser iniciado com "winpty" ficando desta forma: "winpty docker exec -it NOME_OU_ID_CONTAINER bash"
