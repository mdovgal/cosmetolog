<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'type_id',
        'brand_id',
        'title',
        'description',
        'composition',
        'price',
        'image',
        'image_preview',
        'items_on_stock'
    ];

    public function attributes()
    {
        return $this->hasMany('App\ProductAttributes', 'product_id');
    }
}
