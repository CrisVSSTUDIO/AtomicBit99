<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create(['name' => 'Super Admin']);
        $employee = Role::create(['name' => 'Employee']);
        $accountant = Role::create(['name' => 'Accountant']);

      

        $employee->givePermissionTo([
            'create-service',
            'edit-service',
            'create-appoint',
            'edit-appoint'

        ]);
        $accountant->givePermissionTo([
            'manage-statistics',
            
        ]);
    }
}
