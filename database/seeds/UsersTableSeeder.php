<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Адміністратор',
            'email' => 'admin@example.com',
            'password' => Hash::make('demo'),
            'role' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'Покупець',
            'email' => 'customer@example.com',
            'password' => Hash::make('demo'),
            'role' => 'custm'
        ]);
        DB::table('users')->insert([
            'name' => 'Косметолог',
            'email' => 'cosmetolog@example.com',
            'password' => Hash::make('demo'),
            'role' => 'cosmt'
        ]);
    }
}
