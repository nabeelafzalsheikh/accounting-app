<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Admin;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
{
    $this->call([
        AccountTypesAndAccountsSeeder::class,
        TransactionSeeder::class,
        AdminSeeder::class,
    ]);
  

}
}