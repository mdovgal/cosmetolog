<?php

use Illuminate\Database\Seeder;

class ProductTypesTableSeeder extends Seeder
{
    static $types = [
        'Бальзами і олії для тіла',
        'Бустер',
        'Гідролати',
        'Есенції',
        'Ефірні олії',
        'Засоби для губ',
        'Засоби для шкіри навколо очей ',
        'Засоби з кислотами',
        'Кондиціонер',
        'Креми / гелі',
        'Креми для рук',
        'Лосьйони',
        'Маски для волосся',
        'Маски',
        'Мила',
        'Міцелярна вода',
        'Олії для волосся',
        'Олії для тіла',
        'Олії',
        'Очищаючі пінки для обличчя',
        'Пілінги і скраби для обличчя',
        'Сироватки',
        'Спреї',
        'Тоніки/Тонери',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$types as $type) {
            DB::table('product_types')->insert([
                'type_title' => $type
            ]);
        }
    }
}
