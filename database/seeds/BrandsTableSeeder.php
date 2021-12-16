<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
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

    static $brands = [
        [
            'title' => 'A\'PIEU',
            'country' => 'Південна Корея'
        ],
        [
            'title' => 'ASOA',
            'country' => 'Польща'
        ],
        [
            'title' => 'Cosrx',
            'country' => 'Південна Корея'
        ],
        [
            'title' => 'Gyada',
            'country' => 'Італія'
        ],
        [
            'title' => 'Timeless',
            'country' => 'США'
        ],
        [
            'title' => 'Sattva',
            'country' => 'Індія'
        ],
        [
            'title' => 'Bielenda Professional',
            'country' => 'Чехія'
        ],
        [
            'title' => 'Alma Secret',
            'country' => 'Іспанія'
        ],
        [
            'title' => 'NIOD',
            'country' => 'Канада'
        ],
        [
            'title' => 'Evolve Organic Beauty',
            'country' => 'Англія'
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(self::$brands as $brand){
            $country_id = DB::table('countries')->where('country_title', $brand['country'])->first()->id;

            DB::table('brands')->insert([
                'country_id' => $country_id,
                'brand_title' => $brand['title']
            ]);
        }
    }
}
