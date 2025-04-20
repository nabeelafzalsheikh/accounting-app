<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $date = Carbon::now()->format('Y-m-d');
        $transactions = [
            // 1. Owner gives 10M
            ['transaction_group_id' => 1, 'account_id' => 1, 'type' => 'debit', 'amount' => 1000000, 'description' => 'Owner Investment', 'date' => $date],
            ['transaction_group_id' => 1, 'account_id' => 10, 'type' => 'credit', 'amount' => 1000000, 'description' => 'Owner Investment', 'date' => $date],

            // 2. Purchase 5 lakh stock
            ['transaction_group_id' => 2, 'account_id' => 3, 'type' => 'debit', 'amount' => 500000, 'description' => 'Purchase Inventory', 'date' => $date],
            ['transaction_group_id' => 2, 'account_id' => 1, 'type' => 'credit', 'amount' => 500000, 'description' => 'Purchase Inventory', 'date' => $date],

            // 3. Sold 40,000 goods, received 20,000
            ['transaction_group_id' => 3, 'account_id' => 1, 'type' => 'debit', 'amount' => 20000, 'description' => 'Partial Cash from Sale', 'date' => $date],
            ['transaction_group_id' => 3, 'account_id' => 2, 'type' => 'debit', 'amount' => 20000, 'description' => 'Credit from Sale', 'date' => $date],
            ['transaction_group_id' => 3, 'account_id' => 12, 'type' => 'credit', 'amount' => 40000, 'description' => 'Sales Revenue', 'date' => $date],

            // 4. Purchase office items
            ['transaction_group_id' => 4, 'account_id' => 15, 'type' => 'debit', 'amount' => 10000, 'description' => 'Buy Office Items', 'date' => $date],
            ['transaction_group_id' => 4, 'account_id' => 1, 'type' => 'credit', 'amount' => 10000, 'description' => 'Buy Office Items', 'date' => $date],

            // 5. Sold goods 1 lakh, received all
            ['transaction_group_id' => 5, 'account_id' => 1, 'type' => 'debit', 'amount' => 100000, 'description' => 'Cash Sale', 'date' => $date],
            ['transaction_group_id' => 5, 'account_id' => 12, 'type' => 'credit', 'amount' => 100000, 'description' => 'Cash Sale', 'date' => $date],

            // 6. Purchase furniture
            ['transaction_group_id' => 6, 'account_id' => 20, 'type' => 'debit', 'amount' => 20000, 'description' => 'Buy Furniture', 'date' => $date],
            ['transaction_group_id' => 6, 'account_id' => 1, 'type' => 'credit', 'amount' => 20000, 'description' => 'Buy Furniture', 'date' => $date],
        ];

        DB::table('transactions')->insert($transactions);
    }
}
