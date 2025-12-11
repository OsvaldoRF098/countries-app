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
        // Mantén tu factory de prueba si lo quieres
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Llamada con nombre de clase totalmente cualificado (evita ambigüedades)
        $this->call([
            \Database\Seeders\CreateAdminSeeder::class,
        ]);
    }
}
