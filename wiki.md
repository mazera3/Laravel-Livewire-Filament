## Instalação do laravel com Breeze
```sh
laravel new Laravel-React-Filament # instalação do laravel
composer require laravel/breeze --dev # instalação do breeze
php artisan breeze:install # Na tela inicial escolha: React with Inertia; Dark mode; PHPUnit

# editar arquivo .env com as credencias do banco de dados
cp .env.example .env # alterar as variáveis
DB_CONNECTION=mysql
DB_DATABASE=laravel_react_filament
DB_USERNAME=root #  "seu usuario root do mysql (no xamps é root)"
DB_PASSWORD=  #"sua senha para acessar (no xamps é em branco)"

APP_TIMEZONE='America/Sao_Paulo' # UTC
APP_URL=http://localhost:8000 # porta 8000
APP_LOCALE=pt_BR # en
QUEUE_CONNECTION=sync # database

php artisan migrate # executar a migração

php artisan serve # executar a aplicação
```

## Instalação do Filament
```sh
# instalar filament
composer require filament/filament:"^3.2" -W
# instalar panels
php artisan filament:install --panels
# instalar usuario admin
php artisan make:filament-user
# Usuario: Admin
# Email: admin@admin.com
# Senha: 123456

```
# Tradução para Português Brasil
## laravel-pt-BR-localization
```sh
# Instalação: https://github.com/lucascudo/laravel-pt-BR-localization
# Instale o pacote
php artisan lang:publish
composer require lucascudo/laravel-pt-br-localization --dev
php artisan vendor:publish --tag=laravel-pt-br-localization # Publique as traduções
# arquivo .env: APP_LOCALE=pt_BR 
```
# Criar resource User
```sh
# Automatically generating forms and tables
# cria app/Filament/Resources/UserResource.php
php artisan make:filament-resource User --generate
```
# Permissões
## instalar Larevel Permission
- [Laravel-permission](https://spatie.be/docs/laravel-permission/v6/introduction)
- [GitHub](https://github.com/spatie/laravel-permission)
- [Spatie Roles Permissions](https://filamentphp.com/plugins/tharinda-rodrigo-spatie-roles-permissions)
- [GitHub](https://github.com/althinect/filament-spatie-roles-permissions)
- [PlayList](https://www.youtube.com/watch?v=WoHPF2BDcMc&list=PL6tf8fRbavl2oguMj5NSrQXhsd6ztc8_O&index=1)
```sh
composer require spatie/laravel-permission # instalar
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" # publicar
php artisan optimize:clear # ou php artisan config:clear
# cria a tabela permission, roles e relacionamentos
php artisan migrate # atualizar a base de dados
```
## Criar Sedeer Permission
```sh
php artisan make:seeder PermissionSeeder # criar seed PermissionSeeder
# editar PermissionSeeder
```
[PermissionSeeder](database/seeders/PermissionSeeder.php)
```sh
# PermissionSeeder criará roles, permissions e 4 usuários: admin, gerente, usuario e convidado.
```
# Gerando Factors e Seeders de User
## Criar classe Factors de User
```sh
# cria usuários ficticios com datas de cadastros aleatórios
php artisan make:factory UserFactory # criar ou editar UserFactory
# UserFactory: public function definition() deve esta assim:
       $mes = rand(1,12); $dia = rand(1,30);
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123456'),
            'remember_token' => Str::random(10),
            'created_at' => "2024-" . $mes ."-" . $dia ." 19:00:00"
        ];
```
## Criar classe Seeders de User
```sh
php artisan make:seeder UserSeeder # criar ou editar UserSeeder
# criará 100 usuários ficticios para popular a bases de dados
# atribuirá a role Gest para cada usuario. 
# UserSeeder: public function run() deve estar assim:
User::factory()->count(100)->create()->each(function ($usr) {$usr->assignRole('Gest');});
# UserSeeder criará 100 usuários fictícios
```
## Editar classe DatabaseSeeder
```sh
# DatabaseSeeder: public function run() deve esta assim:
$this->call([ PermissionSeeder::class, UserSeeder::class, ]);
```
## Executar seed
```sh
php artisan db:seed # executar seeder
```
# Resourse Permissions e Roles
```sh
# criar app/Filament/Resources/PermissionResource.php
php artisan make:filament-resource Permission --generate
# Editar PermissionResource
```
- [PermissionResource](app/Filament/Resources/PermissionResource.php)
```sh
# criar resourse Role: app/Filament/Resources/RolesResource.php
ph artisan make:filament-resource Role
# Editar RoleResource
```
- [RoleResource](app/Filament/Resources/RoleResource.php)

# Model Permissions e Roles
```sh
# Criar model Permission
# extender de Spatie\Permission\Models\Permission
php artisan make:model Permission

# Criar model Role
# extender de Spatie\Permission\Models\Role
php artisan make:model Role
```
# Relacionamentos com Roles e Permissions
[Integrating with an Eloquent relationship](https://filamentphp.com/docs/3.x/forms/fields/select#integrating-with-an-eloquent-relationship)

## UserResource
```sh
# Tab::make('Relacionamentos')->schema([ aqui... ]),
# roles
Select::make('roles')
->multiple()
->relationship('roles','name',
    fn(Builder $query) => auth()->user()->hasRole('Admin') ? null : $query->where('name', '!=', 'Admin')
)->preload(),
# permissions
Select::make('permissions')->multiple()->relationship('permissions','name')->preload()
```
## RoleResource
```sh
# Tab::make('Permissões')->schema([aqui ... ]),
# permissions
Select::make('permissions')->multiple()->relationship('permissions','name')->preload()
```
# Criando Policies
- Cria políticas para User, Role e Permission
```sh

# cria app/Policies/UserPolicy.php
php artisan make:policy UserPolicy --model=User

# cria app/Policies/RolePolicy.php
php artisan make:policy RolePolicy --model=Role

# cria app/Policies/PermissionPolicy.php
php artisan make:policy PermissionPolicy --model=Permission

```
# Configurando Acesso ao Panel
- [Authorizing access to the panel](https://filamentphp.com/docs/3.x/panels/users#authorizing-access-to-the-panel)
```sh
# Models User
# implementar de FilamentUser
class User extends Authenticatable implements FilamentUser
# usar HasRoles na classe.
use HasRoles
# acrescentar a função com a permissão de Access Panel
public function canAccessPanel(Panel $panel): bool
    {return $this->hasPermissionTo('Access Panel');}
# em AppServiceProvider acrescentar a linha de código:
public function boot(): void
    {
       # acrescentar
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });
    }
# editar políticas
```
- [UserPolicy](./app/Policies/UserPolicy.php)
- [RolePolicy](./app/Policies/RolePolicy.php)
- [PermissionPolicy](./app/Policies/PermissionPolicy.php)

# Implementando Widgets
- [Filament Widgets](https://filamentphp.com/docs/3.x/widgets/installation)
- [Vídeo: How to Create a Dashboard Using Stats, Widgets & Tables in FilamentPHP - FilamentPHP for Beginners](https://youtu.be/lBOQnPUWyZ0?si=BpJy9DNLwnxTnYul)
```sh
# instalar widgets
composer require filament/widgets:"^3.2" -W
php artisan filament:install --widgets
npm install tailwindcss @tailwindcss/forms @tailwindcss/typography postcss postcss-nesting autoprefixer --save-dev
# instalar laravel-trend
composer require flowframe/laravel-trend
npm run dev
php artisan vendor:publish --tag=filament-config
composer update
php artisan filament:upgrade
```
## Criar Widgets
```sh
# criar widgets StatsOverview e UserChart no panel
php artisan make:filament-widget StatsOverview --stats-overview
# editar e deixar assim: User::count() para a model User
protected function getStats(): array
    {
        return [
            Stat::make('Usuários', User::count())
                ->description('Users Registred')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->color('success'), # success, gray, danger, info, primary, warning
            # outros Stats
        ];
    }

php artisan make:filament-widget UserChart --chart
#  para a model User
# editar e deixar assim a função: protected function getData()
$data = Trend::model(User::class)->between( start: now()->startOfYear(), end: now()->endOfYear(), )->perMonth()->count();
return ['datasets' => [['label' => 'Usuários',
            'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
            'backgroundColor' => '#ADFF2F',
            'borderColor' => '#0000CD', ],
], 'labels' => $data->map(fn(TrendValue $value) => $value->date),];
# a função: protected function getType():
    {return 'bar'; }
# a função public function getDescription():
    { return 'O número de usuários registrados por mês!'; }
```
# Notificações
```sh
# Instalação
php artisan filament:install --notifications
php artisan make:queue-batches-table # ignorem a mensagem: Migration already exists.
php artisan vendor:publish --tag=filament-actions-migrations
php artisan make:notifications-table # cra a tabela
php artisan migrate:refresh --seeder
# cria UserObserver
php artisan make:observer UserObserver --model=User
# registrar UserObserver em AppServiceProvider deixando a função: public function boot() assim:
{
    User::observe(UserObserver::class);
    # outros aqui ... 
}
# editar UserObserver
```
- [UserObserver](./app/Observers/UserObserver.php)

# Exporta CSV e XLSX e Importar CSV
```sh
# Criar as tabelas, se não existirem e migração
php artisan make:queue-batches-table
php artisan make:notifications-table
php artisan vendor:publish --tag=filament-actions-migrations
php artisan migrate:refresh --seeder

# Criar uma classe de exportador para a model User
php artisan make:filament-exporter User --generate
php artisan make:filament-importer User --generate
# editar UserResource na propriedade: headerActions e bulkActions
->headerActions([
    ExportAction::make()
        ->exporter(UserExporter::class)
    ImportAction::make()
        ->importer(UserImporter::class)
                ])
->bulkActions([
    DeleteBulkAction::make(),
    ExportBulkAction::make()
        ->exporter(UserExporter::class)
        ])
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

# criar link simbiloco
php artisan storage:link
```
# BelongsToMany em UserResource
# Select::make('roles') ->multiple() ->relationship('roles','name')->preload()
# https://spatie.be/docs/laravel-permission/v6/basic-usage/basic-usage

## Auto-hashing password field
https://filamentphp.com/docs/3.x/forms/advanced#auto-hashing-password-field
