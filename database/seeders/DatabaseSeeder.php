<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Set up the roles and permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // Populate the core data
        $this->call(CoreDataSeeder::class);
    }
}
