## Instalação do laravel
```sh
laravel new projeto00
```
## Instalação do Filament
```sh
# instalar filament
composer require filament/filament:"^3.2" -W
# instyalar panels
php artisan filament:install --panels
# instalar usuario admin
php artisan make:filament-user
# Usuario: Admin
# Email: admin@admin.com
# Senha: 123456

# editar aruivo env com as credencias do banco de dados
cp .env.example .env
# DB_CONNECTION=mysql
# DB_DATABASE=projeto00
# DB_USERNAME="usuario root"
# DB_PASSWORD="senha"
```
## Criar resource
```sh
# Automatically generating forms and tables
# cria app/Filament/Resources/UserResource.php
php artisan make:filament-resource User --generate

```
# laravel-pt-BR-localization
```sh
# Instalação
# https://github.com/lucascudo/laravel-pt-BR-localization
php artisan lang:publish
# Instale o pacote
composer require lucascudo/laravel-pt-br-localization --dev
# Publique as traduções
php artisan vendor:publish --tag=laravel-pt-br-localization
# altere a linha 8 do arquivo .env
APP_LOCALE=pt_BR
```
## Gerando Factors e Seeders
```sh
php artisan make:factory UserFactory
php artisan make:seeder UserSeeder
php artisan db:seed
```
## Implementar Widgets
- [Filament Widgets](https://filamentphp.com/docs/3.x/widgets/installation)
- [Vídeo](https://youtu.be/lBOQnPUWyZ0?si=BpJy9DNLwnxTnYul)
How to Create a Dashboard Using Stats, Widgets & Tables in FilamentPHP - FilamentPHP for Beginners.
```sh
composer require filament/widgets:"^3.2" -W
php artisan filament:install --widgets
npm install tailwindcss @tailwindcss/forms @tailwindcss/typography postcss postcss-nesting autoprefixer --save-dev
composer require flowframe/laravel-trend
npm run dev
php artisan vendor:publish --tag=filament-config
composer update
php artisan filament:upgrade
php artisan make:filament-widget StatsOverview --stats-overview
php artisan make:filament-widget UserChart --chart

# Instalação
php artisan filament:install --notifications
php artisan make:queue-batches-table
php artisan vendor:publish --tag=filament-actions-migrations
php artisan migrate
# Criar uma classe de exportador para a model User
php artisan make:filament-exporter User --generate
QUEUE_CONNECTION=sync # .env: # database
php artisan make:notifications-table
php artisan migrate
php artisan make:observer UserObserver --model=User

php artisan make:filament-importer User --generate

php artisan storage:link
```
# Logos
```sh
# resources/views/filament/logo.blade.php
php artisan make:view filament.logo
# criar tema: resources/css/filament/admin/theme.css 
# e resources/css/filament/admin/tailwind.config.js
php artisan make:filament-theme
npm install
npm run build
```

## Larevel Permission
- [Laravel-permission](https://spatie.be/docs/laravel-permission/v6/introduction)
- [GitHub](https://github.com/spatie/laravel-permission)
- [Spatie Roles Permissions](https://filamentphp.com/plugins/tharinda-rodrigo-spatie-roles-permissions)
- [GitHub](https://github.com/althinect/filament-spatie-roles-permissions)
- [PlayList](https://www.youtube.com/watch?v=WoHPF2BDcMc&list=PL6tf8fRbavl2oguMj5NSrQXhsd6ztc8_O&index=1)
```sh
# instalar
composer require spatie/laravel-permission
# publicar
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
# php artisan optimize:clear or php artisan config:clear
php artisan optimize:clear
# php artisan config:clear
# atualizar a base de dados: cria a tabela permission, roles e relacionamentos
php artisan migrate
```
# Criar Sedeer
```sh
php artisan make:seeder PermissionSeeder
php artisan migrate:refresh --seed
php artisan db:seed --class=UserSeeder

# criar resourse Role: app/Filament/Resources/RolesResource.php
# use Spatie\Permission\Models\Role;
ph artisan make:filament-resource Role

# criar resourse Permission: app/Filament/Resources/PermissionResource.php
php artisan make:filament-resource Permission --generate
```
## Auto-hashing password field
https://filamentphp.com/docs/3.x/forms/advanced#auto-hashing-password-field

## Integrating with an Eloquent relationship
https://filamentphp.com/docs/3.x/forms/fields/select#integrating-with-an-eloquent-relationship
```sh
# BelongsToMany em UserResource
# Select::make('roles') ->multiple() ->relationship('roles','name')->preload()
# https://spatie.be/docs/laravel-permission/v6/basic-usage/basic-usage
# Models User
use HasRoles
```
## Authorizing access to the panel
https://filamentphp.com/docs/3.x/panels/users#authorizing-access-to-the-panel
```sh
# Models User
class User extends Authenticatable implements FilamentUser

# criar resourse Role: app/Filament/Resources/RolesResource.php
# use Spatie\Permission\Models\Role;
php artisan make:filament-resource Role

# criar resourse Permission: app/Filament/Resources/PermissionResource.php
php artisan make:filament-resource Permission --generate

## Generating Policies
```sh
# cria app/Policies/UserPolicy.php
php artisan make:policy UserPolicy --model=User
# cria app/Policies/RolePolicy.php
php artisan make:policy RolePolicy --model=Role
php artisan make:model Role
# cria app/Policies/PermissionPolicy.php
php artisan make:policy PermissionPolicy --model=Permission
php artisan make:model Permission
# cria app/Policies/PostPolicy.php
php artisan make:policy PostPolicy --model=Post
# cria app/Policies/CategoryPolicy.php
php artisan make:policy CategoryPolicy --model=Category
# cria app/Policies/ProjectPolicy.php
php artisan make:policy ProjectPolicy --model=Project
# cria app/Policies/TaskPolicy.php
php artisan make:policy TaskPolicy --model=Task

# Criar Sedeer
pa make:seeder PermissionSeeder
pa make:seeder RoleSeeder
php artisan migrate:refresh --seed
php artisan db:seed --class=UserSeeder
# https://www.luckymedia.dev/blog/laravel-for-beginners-laravel-seeders-for-a-blog-application
```
