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
        // User::factory(10)->create();

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

        Log::info('CreateAdminSeeder: admin creado o actualizado -> ' . $user->email);
    }
}


    }
}
