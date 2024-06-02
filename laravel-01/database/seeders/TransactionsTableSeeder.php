<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the number of transactions to seed
        $numberOfTransactions = 10;

        // Retrieve all users from the database
        $users = User::all();

        // Generate and insert transactions for each user
        foreach ($users as $user) {
            for ($i = 0; $i < $numberOfTransactions; $i++) {
                Transaction::create([
                    'user_id' => $user->id,
                    'date' => now(),
                    'iban' => '1234567890',
                    'bank' => 'Example Bank',
                    'amount' => rand(100, 1000),
                    'currency' => 'USD',
                    'currency_rate' => rand(1, 10) / 10,
                    'result' => rand(100, 1000), // Make sure 'Result example' is a valid string
                ]);
            }
        }
    }
}
