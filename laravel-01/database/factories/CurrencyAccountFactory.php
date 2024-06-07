<?php

namespace Database\Factories;

use App\Models\CurrencyAccount;
use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyAccountFactory extends Factory
{
    protected $model = CurrencyAccount::class;

    public function definition()
    {
        return [
            'bank_account_id' => BankAccount::factory(), // Generates a BankAccount if not provided
            'account_id' => 'CA' . $this->faker->unique()->randomNumber(9), // Ensure uniqueness
            'currency' => $this->faker->currencyCode, // Random currency code
            'balance' => $this->faker->randomFloat(2, 100, 10000), // Random balance between 100 and 10000
        ];
    }
}
