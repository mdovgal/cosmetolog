<?php

use Illuminate\Database\Seeder;

class surveySeeder extends Seeder
{
    static $attributes = [
        ['id' => 29, 'type' => 'skin_type', 'title' => 'Юна'],
        ['id' => 30, 'type' => 'skin_type', 'title' => 'Середньої зрілості'],
        ['id' => 31, 'type' => 'skin_type', 'title' => 'З комедонами'],
        ['id' => 32, 'type' => 'effect', 'title' => 'Звужує пори'],
        ['id' => 33, 'type' => 'effect', 'title' => 'Протизапальний']
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
                'id' => $attr['id'],
                'type' => $attr['type'],
                'title' => $attr['title'],
            ]);
        }
    }
}
