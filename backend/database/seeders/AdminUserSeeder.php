<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@cms.de');
        $password = env('ADMIN_PASSWORD', 'password');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Admin'),
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        if ($user->wasRecentlyCreated) {
            $this->command->info('✅ Admin user created successfully!');
        } else {
            $this->command->info('ℹ️  Admin user already exists.');
        }

        $this->command->line('');
        $this->command->line('Login credentials:');
        $this->command->line("Email: {$email}");
        $this->command->line("Password: {$password}");
        $this->command->line('');
    }
}
