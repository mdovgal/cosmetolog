<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    protected $table = 'v_products';

    public function attributes()
    {
        return $this->hasMany('App\ProductAttributes', 'product_id');
    }
}
