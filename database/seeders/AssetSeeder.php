<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $letters = 'abcdefghijklmnopqrstuvwxyz';
        for ($i = 0; $i <= 640; $i++) {
            DB::table('assets')->insert([
                'name' => substr(str_shuffle($letters), 0, 10),
                'slug' => substr(str_shuffle($letters), 0, 10),
                'description' => substr(str_shuffle($letters), 0, 20),
                'upload' => 'public/1707579902_cube.jpg',
                'filetype' => 'jpeg',
                'filesize' => 0.000342,
                'user_id' => 1,
                'created_at' => Carbon::parse('2026-01-01'),
                'updated_at' => Carbon::parse('2026-01-01'),
                'deleted_at'=>NULL
            ]);
        }
    }
}
