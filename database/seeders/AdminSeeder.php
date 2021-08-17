<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Will Create 2 Admin Records in DB
        \App\Models\Admin::factory(2)->create();
    }
}
