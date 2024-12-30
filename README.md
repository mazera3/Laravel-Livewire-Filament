# Projeto Laravel-React-Filament
## Requisitos

* PHP 8.2 ou superior;
* MySQL 8 ou superior;
* Composer;
* Node.js 20 ou superior;
* filamente 3.2 ou superior
* git
* laravel-pt-BR-localization

# Como Rodar o Projeto

* Duplicar o arquivo ".env.example" e renomear para ".env".
* Alterar no arquivo .env as credenciais do banco de dados.
```sh
composer install # Instalar as dependências do PHP
npm install # Instalar as dependências do Node.js.
php artisan key:generate # Gerar a chave
php artisan migrate --seeder # Executar as migration para criar a base de dados e as tabelas.
php artisan serve # Iniciar o projeto criado com Laravel.
npm run dev # Executar as bibliotecas Node.js.
http://127.0.0.1:8000 # Acessar no navegador a URL
```
# Como Implementar esse projeto
Consulte a documentação wiki [aqui](https://github.com/mazera3/Laravel-React-Filament/wiki)