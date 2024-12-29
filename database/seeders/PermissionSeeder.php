<?php

namespace Database\Seeders;

// use App\Models\Permission;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // Permissões
        //************************ Admin ****************************** */
        // Cria sa regras
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleManager = Role::create(['name' => 'Manager']);
        $roleUser = Role::create(['name' => 'User']);
        $roleGest = Role::create(['name' => 'Gest']);

        // Ctia as permissões
        $permissions = [
            'Access Panel',
            'Info Permission',
            'View Permission',
            'Create Permission',
            'Update Permission',
            'Delete Permission',
            'Info Role',
            'View Role',
            'Create Role',
            'Update Role',
            'Delete Role',
            'Info User',
            'View User',
            'Create User',
            'Update User',
            'Delete User'
        ];
        // Cria sa permissões
        foreach ($permissions as $permission) {
            Permission::Create(['name' => $permission]);
        };

        // Cria Admin
        $Admin = User::Create([
            'id'        => 1,
            'name'      => 'Admin',
            'email'     => 'admin@admin.com',
            'password' => Hash::make('123456'),
        ]);
        // Adiciona regra a user admin
        $Admin->assignRole('Admin');
        // Sincroniza permissoes a regra
        $roleAdmin->syncPermissions($permissions);

        //*********************** Manager ******************************* */
        // Cria Manager
        $Manager = User::Create([
            'id'        => 2,
            'name'      => 'Gerente',
            'email'     => 'gerente@gerente.com',
            'password' => Hash::make('123456'),
        ]);
        // Adiciona regra a user Manager
        $Manager->assignRole('Manager');
        $permissionsMageger = [
            'Access Panel',
            'Info User',
            'View User',
            'Create User',
            'Update User',
            'Delete User'
        ];
        // Sincroniza permissoes a regra
        $roleManager->syncPermissions($permissionsMageger);

        //************************ User ************************************** */

        $User = User::Create([
            'id'        => 3,
            'name'      => 'Usuario',
            'email'     => 'user@user.com',
            'password' => Hash::make('123456'),
        ]);

        // Adiciona regra a user User
        $User->assignRole('User');
        $permissionsUser = [
            'Access Panel',
        ];
        // Sincroniza permissoes a regra
        $roleUser->syncPermissions($permissionsUser);

        //************************ Gest ************************************** */

        $Gest = User::Create([
            'id'        => 4,
            'name'      => 'Convidado',
            'email'     => 'gest@gest.com',
            'password' => Hash::make('123456'),
        ]);
        // Adiciona regra a user Gest
        $Gest->assignRole('Gest');
        $permissionsGest = [];
        // Sincroniza permissoes a regra
        $roleGest->syncPermissions($permissionsGest);
    }
}
