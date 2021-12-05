<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    static $categories = [
        'Готичний стиль',
        'Бароко',
        'Класицизм',
        'Сентименталізм',
        'Романтизм',
        'Реалізм',
        'Символізм',
        'Імпресіонізм',
        'Сюрреалізм',
        'Кубізм',
        'Футуризм',
        'Абстракционизм',
        'Постмодернізм'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$categories as $category) {
            DB::table('category')->insert([
                'title' => $category
            ]);
        }
    }
}
