<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'status',
        'status_changed_at'
    ];

    public function cart_items()
    {
        return $this->hasMany('App\CartItems', 'cart_id');
    }
}
