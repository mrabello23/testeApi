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
- Abrir a aplicação no endereço "http://localhost:8080/"
- Ao final dos testes acessar pasta da aplicação via git bash e executar comando "docker-compose down" para encerrar os containers

## Testes unitários
- Acessar pasta da aplicação via git bash
- Executar comando "docker-compose up -d" para iniciar o container
- Executar comando "winpty docker exec -it web_app bash" para acessar o container da aplicação
- Na raiz do projeto, executar o comando "vendor/bin/phpunit" para rodar a suite de teste
- Ao final executar comando "exit" para sair do container e executar comando "docker-compose down" para encerrar os containers
