<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyAccountIdToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Ensure the currency_accounts table exists before adding the foreign key
            if (Schema::hasTable('currency_accounts')) {
                $table->unsignedBigInteger('currency_account_id')->nullable()->after('id');
                $table->foreign('currency_account_id')
                      ->references('id')
                      ->on('currency_accounts')
                      ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['currency_account_id']);
            $table->dropColumn('currency_account_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            // If the column doesn't exist, it won't try to drop it, preventing errors
            if (Schema::hasColumn('transactions', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
}
