<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    protected $table = 'cart_items';

    public $timestamps = false;

    protected $fillable = [
        'cart_id',
        'product_id',
        'count_items'
    ];
}
