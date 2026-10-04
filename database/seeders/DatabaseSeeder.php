<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@vortexmedia.com'],
            [
                'nama' => 'admin',
                'nomor_telepon' => '081234567890',
                'email' => 'admin@vortexmedia.com',
                'password' => 'password123',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@vortexmedia.com'],
            [
                'nama' => 'user1',
                'nomor_telepon' => '089876543210',
                'email' => 'user@vortexmedia.com',
                'password' => 'password123',
            ]
        );

        $this->call(RyanZidanSeeder::class);
    }
}
