<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CreateAdminSeeder extends Seeder
{
    public function run()
    {
        $user = User::updateOrCreate(
            ['email' => 'osvaldoramirezflores098@gmail.com'],
            [
                'name' => 'Admin Temporal',
                'email_verified_at' => now(),
                'password' => Hash::make('Osvaldo1'),
                'remember_token' => Str::random(10),
            ]
        );

        // Esto deja una línea en los Deploy Logs confirmando que el admin se creó
        Log::info('CreateAdminSeeder: admin creado o actualizado -> ' . $user->email);
    }
}
