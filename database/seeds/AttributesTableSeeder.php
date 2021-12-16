<?php

use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    static $attributes = [
        ['type' => 'skin_type', 'title' => 'Жирна'],
        ['type' => 'skin_type', 'title' => 'З куперозом'],
        ['type' => 'skin_type', 'title' => 'Зріла'],
        ['type' => 'skin_type', 'title' => 'Кожен тип шкіри'],
        ['type' => 'skin_type', 'title' => 'Комбінована'],
        ['type' => 'skin_type', 'title' => 'Нормальна'],
        ['type' => 'skin_type', 'title' => 'Проблемна'],
        ['type' => 'skin_type', 'title' => 'Суха'],
        ['type' => 'skin_type', 'title' => 'Чутлива'],
        ['type' => 'skin_type', 'title' => 'Пігментована'],
        ['type' => 'skin_type', 'title' => 'З ознаками старіння'],
        ['type' => 'effect', 'title' => 'Anti-age'],
        ['type' => 'effect', 'title' => 'Антиоксидантна'],
        ['type' => 'effect', 'title' => 'Антицелюлітна'],
        ['type' => 'effect', 'title' => 'Відлущуюча'],
        ['type' => 'effect', 'title' => 'Заспокійлива'],
        ['type' => 'effect', 'title' => 'Захист від сонця'],
        ['type' => 'effect', 'title' => 'Зволожуюча'],
        ['type' => 'effect', 'title' => 'Підсушуючий'],
        ['type' => 'effect', 'title' => 'Освітлююча'],
        ['type' => 'effect', 'title' => 'Очищаюча'],
        ['type' => 'effect', 'title' => 'Поживна'],
        ['type' => 'effect', 'title' => 'Проти почервонінь'],
        ['type' => 'effect', 'title' => 'Проти пігментації'],
        ['type' => 'effect', 'title' => 'Підтягуюча'],
        ['type' => 'effect', 'title' => 'Регенеруюча'],
        ['type' => 'effect', 'title' => 'Розгладжуюча'],
        ['type' => 'effect', 'title' => 'Тонізуюча']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$attributes as $attr) {
            DB::table('attributes')->insert([
                'type' => $attr['type'],
                'title' => $attr['title'],
            ]);
        }
    }
}
