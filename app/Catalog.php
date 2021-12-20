<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
https://si-dev.com/ru/blog/laravel-multilevel-menu
*/

class Catalog extends Model
{
    protected $table = 'catalog';

    protected $fillable = [
        'parent_id',
        'title'
    ];

    public function parent()
    {
        return $this->belongsTo(Catalog::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Catalog::class, 'parent_id');
    }

    public function scopeOfSort($query, $sort)
    {
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query;
    }

    public function products()
    {
        return $this->hasMany('App\ProductView', 'category_id');
    }
}
