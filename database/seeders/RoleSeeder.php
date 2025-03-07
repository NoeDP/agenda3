<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Editor']);
        $role3 = Role::create(['name' => 'Gestor_eventos']);

        Permission::create(['name' => 'Visualizar usuarios'])->assignRole($role1);
        Permission::create(['name' => 'Crear usuario'])->assignRole($role1);
        Permission::create(['name' => 'Eliminar usuario'])->assignRole($role1);

        Permission::create(['name' => 'Crear evento'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'Editar evento'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'Eliminar evento'])->syncRoles([$role1,$role2,$role3]);

        Permission::create(['name' => 'Crear foro'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'Editar foro'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'Eliminar foro'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'Crear organizador'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'Editar organizador'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'Eliminar organizador'])->syncRoles([$role1,$role2]);

       

        // Crear usuario de prueba con el rol "Admin"
        $user = User::firstOrCreate(
            ['email' => 'admin@admin'], // Evita duplicados
            [
                'name' => 'Noe Diaz',
                'telefono' => '1234567890',
                'codigo' => '1234567',
                'password' => bcrypt('12345678'),
            ]
        );

        // Asignar el rol "Admin" al usuario
        if (!$user->hasRole('Admin')) {
            $user->assignRole($role1);
            $this->command->info('✅ Usuario de prueba creado y asignado al rol "Admin".');
        } else {
            $this->command->info('🔹 El usuario ya tenía el rol "Admin".');
        }

        $us = User::firstOrCreate(
            ['email' => 'editor@soy.utj.edu.mx'], // Evita duplicados
            [
                'name' => 'Eliot cabrera',
                'telefono' => '1234567899',
                'codigo' => '1234566',
                'password' => bcrypt('12345678'),
            ]
        );

        // Asignar el rol "Admin" al usuario
        if (!$us->hasRole('Editor')) {
            $us->assignRole($role2);
            $this->command->info('✅ Usuario de prueba creado y asignado al rol "Editor".');
        } else {
            $this->command->info('🔹 El usuario ya tenía el rol "Editor".');
        }
    }
}
