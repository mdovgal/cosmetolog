<?php
require_once('CategoryTableSeeder.php');
//require_once('UsersTableSeeder.php');

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
    }
}
