<?php

use Illuminate\Database\Seeder;

class Courier extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
        	'name' => 'PMT Logistics'      	
        ]);
    }
}
