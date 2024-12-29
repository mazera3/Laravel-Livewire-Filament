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
# DB_DATABASE=painel
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
