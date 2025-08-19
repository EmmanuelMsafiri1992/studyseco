<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

/**
 * This seeder sets up the roles and permissions using the Spatie package.
 */
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create the roles for the different user types
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleTeacher = Role::firstOrCreate(['name' => 'teacher']);
        $roleStudent = Role::firstOrCreate(['name' => 'student']);

        // Define permissions here
        // Example:
        // $createLessons = Permission::firstOrCreate(['name' => 'create lessons']);
        // $editLessons = Permission::firstOrCreate(['name' => 'edit lessons']);
        // $viewLessons = Permission::firstOrCreate(['name' => 'view lessons']);

        // Assign permissions to roles
        // $roleAdmin->givePermissionTo(Permission::all()); // Admins get all permissions
        // $roleTeacher->givePermissionTo([$createLessons, $editLessons]);
        // $roleStudent->givePermissionTo($viewLessons);
    }
}
