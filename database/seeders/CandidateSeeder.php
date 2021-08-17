<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Will Create 15 Candidates in Db.
        \App\Models\Candidate::factory(15)->create();
    }
}
