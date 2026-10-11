<?php

namespace Database\Seeders;

use App\Models\Komputer;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DashboardSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];

        foreach ([
            ['nama' => 'Andi Pratama', 'nomor_telepon' => '081234567801', 'email' => 'andi@example.com'],
            ['nama' => 'Siti Rahma', 'nomor_telepon' => '081234567802', 'email' => 'siti@example.com'],
            ['nama' => 'Budi Santoso', 'nomor_telepon' => '081234567803', 'email' => 'budi@example.com'],
            ['nama' => 'Rina Amelia', 'nomor_telepon' => '081234567804', 'email' => 'rina@example.com'],
        ] as $userData) {
            $users[$userData['email']] = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    ...$userData,
                    'password' => Hash::make('password123'),
                ]
            );
        }

        $computers = [];

        foreach ([
            ['nomor_komputer' => 1, 'spek_komputer' => 'Intel Core i5, RAM 16 GB, GTX 1660', 'status_komputer' => 'dipakai'],
            ['nomor_komputer' => 2, 'spek_komputer' => 'Intel Core i5, RAM 16 GB, RTX 2060', 'status_komputer' => 'dipakai'],
            ['nomor_komputer' => 3, 'spek_komputer' => 'AMD Ryzen 5, RAM 16 GB, GTX 1660', 'status_komputer' => 'dipesan'],
            ['nomor_komputer' => 4, 'spek_komputer' => 'AMD Ryzen 5, RAM 16 GB, RTX 3060', 'status_komputer' => 'kosong'],
            ['nomor_komputer' => 5, 'spek_komputer' => 'Intel Core i7, RAM 32 GB, RTX 3060', 'status_komputer' => 'maintenance'],
        ] as $computerData) {
            $computers[$computerData['nomor_komputer']] = Komputer::firstOrCreate(
                ['nomor_komputer' => $computerData['nomor_komputer']],
                $computerData
            );
        }

        foreach ([
            [
                'email' => 'andi@example.com',
                'nomor_komputer' => 1,
                'waktu_mulai' => '07:00:00',
                'lama_pemesanan' => 2,
                'waktu_akhir' => '09:00:00',
                'status' => 'diterima',
            ],
            [
                'email' => 'siti@example.com',
                'nomor_komputer' => 2,
                'waktu_mulai' => '07:30:00',
                'lama_pemesanan' => 1,
                'waktu_akhir' => '08:30:00',
                'status' => 'diterima',
            ],
            [
                'email' => 'budi@example.com',
                'nomor_komputer' => 3,
                'waktu_mulai' => '08:00:00',
                'lama_pemesanan' => 2,
                'waktu_akhir' => '10:00:00',
                'status' => 'pending',
            ],
            [
                'email' => 'rina@example.com',
                'nomor_komputer' => 4,
                'waktu_mulai' => '09:00:00',
                'lama_pemesanan' => 1,
                'waktu_akhir' => '10:00:00',
                'status' => 'ditolak',
            ],
        ] as $orderData) {
            $user = $users[$orderData['email']];
            $computer = $computers[$orderData['nomor_komputer']];
            $duration = $orderData['lama_pemesanan'];

            Pemesanan::updateOrCreate(
                [
                    'id_user' => $user->id_user,
                    'computer_id' => $computer->id_komputer,
                    'waktu_mulai' => $orderData['waktu_mulai'],
                ],
                [
                    'tanggal_pemesanan' => now()->toDateString(),
                    'lama_pemesanan' => $duration,
                    'waktu_akhir' => $orderData['waktu_akhir'],
                    'nominal' => $duration * 7000,
                    'status' => $orderData['status'],
                    'alasan_ditolak' => $orderData['status'] === 'ditolak' ? 'Contoh pesanan ditolak.' : null,
                ]
            );
        }
    }
}
