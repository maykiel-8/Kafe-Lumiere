<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // ── Staff ──────────────────────────────────────────
            [
                'first_name'        => 'Admin',
                'last_name'         => 'Lumière',
                'email'             => 'admin@kafelumiere.com',
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Maria',
                'last_name'         => 'Santos',
                'email'             => 'cashier@kafelumiere.com',
                'password'          => Hash::make('password'),
                'role'              => 'cashier',
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Juan',
                'last_name'         => 'Dela Cruz',
                'email'             => 'juan@kafelumiere.com',
                'password'          => Hash::make('password'),
                'role'              => 'cashier',
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            // ── Customers ──────────────────────────────────────
            [
                'first_name'        => 'Anna',
                'last_name'         => 'Cruz',
                'email'             => 'customer@kafelumiere.com',
                'password'          => Hash::make('password'),
                'role'              => 'customer',
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Jose',
                'last_name'         => 'Reyes',
                'email'             => 'jose@email.com',
                'password'          => Hash::make('password'),
                'role'              => 'customer',
                'status'            => 'active',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $data) {
            // firstOrCreate — skips the row if email already exists
            // so running db:seed multiple times never causes duplicate errors
            User::firstOrCreate(
                ['email' => $data['email']], // search by email
                $data                        // create with these values if not found
            );
        }
    }
}