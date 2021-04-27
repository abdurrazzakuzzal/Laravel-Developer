<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'id', 'variant', 'variant_id', 'product_id'
    ];

    public function variants()
    {
        return $this->hasMany('App\Models\Variant','id', 'variant_id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product','id', 'product_id');
    }
}
