<?php

use Illuminate\Database\Seeder;

class Settings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
        	'site_title' => 'Perfect Mall Deliveries'      	
        ]);
    }
}
