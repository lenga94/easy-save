<?php

use Illuminate\Database\Seeder;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Transaction::class, 150)->create();
    }
}
