<?php

use Illuminate\Database\Seeder;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'role' => 1,
        	'firstname' => 'Perfect',
        	'lastname' =>  'Mall',
        	'email_address' => 'admin@perfectmall.ng',
        	'password' => Hash::make('test')     	
        ]);
    }
}
