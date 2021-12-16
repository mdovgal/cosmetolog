<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    static $countries = [
        'Індія',
        'Іспанія',
        'Австралія',
        'Англія',
        'Данія',
        'Канада',
        'Польща',
        'Південна Корея',
        'США',
        'Угорщина',
        'Франція',
        'Швеція',
        'Італія',
        'Чехія'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$countries as $country) {
            DB::table('countries')->insert([
                'country_title' => $country
            ]);
        }
    }
}
