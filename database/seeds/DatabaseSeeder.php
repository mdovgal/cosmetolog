<?php
require_once('UsersTableSeeder.php');
require_once('CategoryTableSeeder.php');
require_once('CountriesTableSeeder.php');
require_once('BrandsTableSeeder.php');
require_once('ProductTypesTableSeeder.php');
require_once('AttributesTableSeeder.php');

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
         $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
         $this->call(CountriesTableSeeder::class);
         $this->call(BrandsTableSeeder::class);
        $this->call(ProductTypesTableSeeder::class);
        $this->call(AttributesTableSeeder::class);
    }
}
