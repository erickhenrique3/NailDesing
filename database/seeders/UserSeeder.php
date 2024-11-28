<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $clientId = DB::table('oauth_clients')->insertGetId([
                'name' => 'Laravel Personal Access Client',
                'secret' => Str::random(40),
                'redirect' => '',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('oauth_personal_access_clients')->insert([
                'client_id' => $clientId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info('Personal Access Client criado com sucesso.');
        } catch (\Exception $e) {
            $this->command->error("Erro ao criar o Personal Access Client: " . $e->getMessage());
            return;
        }

        try {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'phone' => '1234567890',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);

            $token = $user->createToken('Personal Access Token')->accessToken;

            $this->command->info("Usuário criado com sucesso. Token: $token");
        } catch (\Exception $e) {
            $this->command->error("Erro ao criar o usuário: " . $e->getMessage());
        }
    }
}
