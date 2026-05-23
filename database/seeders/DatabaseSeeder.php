<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Llamamos a tus productos existentes
        $this->call(ProductSeeder::class);

        // 2. Creamos o actualizamos el usuario Demo para los reclutadores
        User::updateOrCreate(
            ['email' => 'admin@cartforge.com'],
            [
                'name' => 'Guest Recruiter',
                'password' => Hash::make('password123'),
            ]
        );
    }
}