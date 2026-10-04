<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RyanZidanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'ryan@gmail.com'],
            [
                'nama' => 'ryan',
                'password' => Hash::make('tes'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'zidan@gmail.com'],
            [
                'nama' => 'zidan',
                'password' => Hash::make('tes'),
            ]
        );
    }
}
