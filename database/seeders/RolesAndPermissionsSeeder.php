<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        // Project permissions
        Permission::create(['name' => 'view projects']);
        Permission::create(['name' => 'create projects']);
        Permission::create(['name' => 'edit projects']);
        Permission::create(['name' => 'delete projects']);
        
        // Volunteer permissions
        Permission::create(['name' => 'view volunteers']);
        Permission::create(['name' => 'create volunteers']);
        Permission::create(['name' => 'edit volunteers']);
        Permission::create(['name' => 'delete volunteers']);
        
        // Create roles and assign permissions
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
        
        // Project Manager role
        $managerRole = Role::create(['name' => 'project_manager']);
        $managerRole->givePermissionTo([
            'view projects', 'create projects', 'edit projects',
            'view volunteers'
        ]);
        
        // Volunteer role
        $volunteerRole = Role::create(['name' => 'volunteer']);
        $volunteerRole->givePermissionTo([
            'view projects'
        ]);
        
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');
        
        // Create project manager user
        $manager = User::create([
            'name' => 'Project Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
        ]);
        $manager->assignRole('project_manager');
        
        // Create volunteer user
        $volunteer = User::create([
            'name' => 'Volunteer User',
            'email' => 'volunteer@example.com',
            'password' => bcrypt('password'),
        ]);
        $volunteer->assignRole('volunteer');
    }
}
