# Teste Web e Api

- Acessar pasta da aplicação via git bash
- Executar comando "docker-compose build" no git bash para criar as imagens do container
- Executar comando "docker-compose up -d" no git bash para iniciar o container
- Executar comando "winpty docker exec -it web_app bash" no git bash para acessar o container "web_app"
- Executar comando "cd /var/www/html/" para acessar o caminho do projeto
- Executar comando "php artisan migrate:fresh --seed" para criar o BD
- Executar comando "exit" para sair do container
- Abrir a aplicação no endereço "http://localhost:8080/"
- Ao final dos testes acessar pasta da aplicação via git bash e executar comando "docker-compose down" para encerrar os containers