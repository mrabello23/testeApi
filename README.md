# Teste Web e Api

## Requisitos
- Docker instalado
- Git bash instalado
- Spotify (codar ouvindo um som é bom demais)
- Café (indispensável)


## Executar projeto
- Acessar pasta da aplicação via git bash
- Executar comando "docker-compose build" para criar as imagens dos containers
- Executar comando "docker-compose up -d" para iniciar os containers
- Projeto estará acessível via browser após instalação / atualização das dependências
- Primeira execução de "docker-compose build" e "docker-compose up -d" será um pouco demorada (entre 5 a 15 minutos variando de acordo com a rede)
- Abrir a aplicação no endereço "http://localhost:8080/"
- Ao final dos testes acessar pasta da aplicação via git bash e executar comando "docker-compose down" para encerrar os containers


## Testes unitários
- Acessar pasta da aplicação via git bash
- Executar comando "docker-compose build" para criar as imagens dos containers caso não tenha sido feito no passo anterior
- Executar comando "docker-compose up -d" para iniciar os containers
- Projeto estará acessível para teste via bash após instalação / atualização das dependências
- Primeira execução de "docker-compose build" e "docker-compose up -d" será um pouco demorada (entre 5 a 15 minutos variando de acordo com a rede)
- Executar comando "winpty docker exec -it web_app bash" para acessar o container da aplicação ("web_app" foi nome setado no docker-compose.yml)
- Na raiz do projeto, executar o comando "vendor/bin/phpunit" para rodar a suite de teste
- Ao final executar comando "exit" para sair do container e executar comando "docker-compose down" para encerrar os containers
