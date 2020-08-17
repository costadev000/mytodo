<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Isaac',
            'email' => 'aaa@aaa.com',
            'password' => Crypt::encrypt('123'),
            'status' => true
        ]);
    }
}
