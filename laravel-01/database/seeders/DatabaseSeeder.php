<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test1@example.com',
            'password' => 'test',
        ]);
        // User::factory(10)->create();
        $this->call([
            // Other seeders can be added here
            BankAccountSeeder::class,
            CurrencyAccountSeeder::class,
            TransactionsTableSeeder::class,
        ]);

      
    }
}
