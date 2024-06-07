<?php
namespace Database\Seeders;

use App\Models\CurrencyAccount;
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
        $currencyAccounts = CurrencyAccount::all();

        // Generate and insert transactions for each user
        foreach ($currencyAccounts as $currencyAccount) {
            for ($i = 0; $i < $numberOfTransactions; $i++) {
                Transaction::create([
                    'currency_account_id' => $currencyAccount->id,
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
