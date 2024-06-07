<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankAccount;
use App\Models\User;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assuming you have some users already created in your User table
        $users = User::all();

        foreach ($users as $user) {
            // Create multiple bank accounts for each user
            BankAccount::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
