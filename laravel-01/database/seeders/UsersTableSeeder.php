<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the number of users to seed
        $numberOfUsers = 10;

        // Generate and insert users
        for ($i = 0; $i < $numberOfUsers; $i++) {
            User::create([
                'name' => 'User' . ($i + 1), // Generate a unique name for each user
                'email' => 'user' . ($i + 1) . '@example.com', // Generate a unique email for each user
                'password' => bcrypt('password'), // Set a default password for all users
                // Add more fields as needed
            ]);
        }
    }
}
