<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankAccount;
use App\Models\CurrencyAccount;

class CurrencyAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all bank accounts
        $bankAccounts = BankAccount::all();

        foreach ($bankAccounts as $bankAccount) {
            // Create multiple currency accounts for each bank account
            CurrencyAccount::factory()->count(3)->create([
                'bank_account_id' => $bankAccount->id,
                'account_id' => 'CA' . $bankAccount->id . rand(1000, 9999), // Unique account ID
                'currency' => 'USD', // or other logic to determine currency
                'balance' => rand(1000, 10000), // or other logic to determine balance
            ]);
        }
    }
}
