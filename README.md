# Projeto Laravel-React-Filament
## Requisitos

* PHP 8.2 ou superior;
* MySQL 8 ou superior;
* Composer;
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
php artisan migrate # Executar as migration para criar a base de dados e as tabelas.
php artisan db:seed # executar seeder
php artisan serve # Iniciar o projeto criado com Laravel.
http://127.0.0.1:8000 # Acessar no navegador a URL
```
# Como Implementar esse projeto
Consulte a documentação wiki [aqui](https://github.com/mazera3/Laravel-React-Filament/wiki)

# Implementar Laravel com Breeze e Livewire/Alphine
```sh
# instala o laravel com breeze
composer require laravel/breeze --dev
php artisan breeze:install # Escolha: Livewire (Volt Class API) with Alpine 
# No laravel+breeze já esta instalado o livewire/Alpine

# ****************** Solução de erros de acesso ao Panel Filament ****************************
# adicione em vite.config.js
'resources/css/filament/admin/theme.css'
# execute: npm run build
npm run build
# ************* Redirecionamento do Painel **************************************************
1. Criar a classe: CustonLogoutResponse.php no diretório "app/Http/Responses/"
2. Copiar o conteudo de LogoutResponse: "/vendor/filament/filament/src/Http/Responses/Auth/LogoutResponse.php"
3. Em AdminPanelProvider, acrescentar a linha: 
->bootUsing(function () {
    // ... outros
    app()->bind(LogoutResponse::class, CustonLogoutResponse::class); 
    })

# verificar se existe o arquivo: resources/views/components/layouts/app.blade.php
# se não existir, criar.
php artisan livewire:layout # cria um layout geral para todos os componentes
```
## Criar um novo componente livewire: Counter 
```sh
php artisan make:livewire tutorial.counter
# CLASS: app/Livewire/Tutorial/Counter.php
# VIEW:  resources/views/livewire/tutorial/counter.blade.php
# seguir o tutorial da documentação: https://livewire.laravel.com/docs/quickstart
# Testar o componente, visitar: /counter
```
## Criar um novo componente livewire: Todo
```sh
# cria um componente chamado todo no subdiretório tutorial.todo
php artisan make:livewire tutorial.todo
# CLASS: app/Livewire/Tutorial/Todo.php
# VIEW:  resources/views/livewire/tutorial/todo.blade.php
# acrescentar em Todo.php o código a seguir:

public $todos = [];
public $todo = '';
public function add()
    {
        $this->todos[] = $this->todo;
        $this->todo = '';
    }

# Acrescenta em todo.blade.php

<div>
    <input type="text" wire:model="todo" /> 
    <button wire:click="add">Add</button>
    <ul>
        @foreach ($todos as $todo)
            <li>{{ $todo }}</li>
        @endforeach
    </ul>
</div>

# Criar uma rota: Route::get('/todo', Todo::class);
# visitar a rota
```
## Criar um novo componente livewire: PostList
```sh
php artisan make:livewire posts.postList
# CLASS: app/Livewire/Posts/PostList.php
# VIEW:  resources/views/livewire/posts/post-list.blade.php



# https://livewire.laravel.com/docs/forms
# https://github.com/yelocode/tailwind-css-blog/blob/main/home.html
[Home Page | Build Blog with Laravel, Livewire & Filament](https://youtu.be/nGyowsfRY5s?si=Xe5k_8V_G3ygWXrz)
[Laravel Livewire - Primeiros Passos](https://youtu.be/e83fM_0mGa8?si=dZqEY3iDk7oRv9N7)

[LIVEWIRE V3 🔥🐘 INSANO!](https://youtu.be/6wmkn3GYFbc?si=R4KL7I9HXw9yghWq)

php artisan make:livewire Tasks
# CLASS: app/Livewire/Tasks.php
# VIEW:  resources/views/livewire/tasks.blade.php