<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Asset;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AssetSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // p
        /*        User::create([
            'name' => 'Kira',
            'email' => 'kira@example.com',
            'password' => Hash::make('123456789'),
        
        ]); */
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            SuperAdminSeeder::class,
            // AssetSeeder::class
        ]);
    }
}
