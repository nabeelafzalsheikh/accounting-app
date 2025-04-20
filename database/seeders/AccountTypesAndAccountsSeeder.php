<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountTypesAndAccountsSeeder extends Seeder
{
    public function run()
    {
        // Seed Account Types
        $accountTypes = [
            ['name' => 'Assets', 'slug' => 'assets'],
            ['name' => 'Liabilities', 'slug' => 'liabilities'],
            ['name' => 'Equity', 'slug' => 'equity'],
            ['name' => 'Revenue', 'slug' => 'revenue'],
            ['name' => 'Expenses', 'slug' => 'expenses'],
        ];

        DB::table('account_types')->insert($accountTypes);

        // Seed Accounts
        $accounts = [
            // Assets
            ['name' => 'Cash', 'type_id' => 1, 'color' => '#3c8dbc'],
            ['name' => 'Accounts Receivable', 'type_id' => 1, 'color' => '#3c8dbc'],
            ['name' => 'Inventory', 'type_id' => 1, 'color' => '#3c8dbc'],
            ['name' => 'Equipment', 'type_id' => 1, 'color' => '#3c8dbc'],
            ['name' => 'Buildings', 'type_id' => 1, 'color' => '#3c8dbc'],
            ['name' => 'Land', 'type_id' => 1, 'color' => '#3c8dbc'],
            
            // Liabilities
            ['name' => 'Accounts Payable', 'type_id' => 2, 'color' => '#f39c12'],
            ['name' => 'Loans Payable', 'type_id' => 2, 'color' => '#f39c12'],
            ['name' => 'Salaries Payable', 'type_id' => 2, 'color' => '#f39c12'],
            
            // Equity
            ['name' => 'Owner\'s Capital', 'type_id' => 3, 'color' => '#00a65a'],
            ['name' => 'Retained Earnings', 'type_id' => 3, 'color' => '#00a65a'],
            
            // Revenue
            ['name' => 'Sales Revenue', 'type_id' => 4, 'color' => '#00c0ef'],
            ['name' => 'Service Revenue', 'type_id' => 4, 'color' => '#00c0ef'],
            
            // Expenses
            ['name' => 'Rent Expense', 'type_id' => 5, 'color' => '#dd4b39'],
            ['name' => 'Salaries Expense', 'type_id' => 5, 'color' => '#dd4b39'],
            ['name' => 'Utilities Expense', 'type_id' => 5, 'color' => '#dd4b39'],
        ];

        DB::table('accounts')->insert($accounts);
    }
}