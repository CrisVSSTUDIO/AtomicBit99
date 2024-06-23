<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Kira',
            'email' => 'kira@example.com',
            'password' => Hash::make('123456789')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $employee = User::create([
            'name' => 'Teacher',
            'email' => 'teacher@example.com',
           
            'password' => Hash::make('123456789')
        ]);
        $employee->assignRole('Employee');

        // Creating Product Manager User
        $accountant = User::create([
            'name' => 'accountant',
            'email' => 'accountant@example.com',
            'password' => Hash::make('123456789'),
           

        ]);
        $accountant->assignRole('Accountant');

    }
}
