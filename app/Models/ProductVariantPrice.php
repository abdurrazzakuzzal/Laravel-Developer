<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model
{
    protected $fillable = [
        'product_variant_one','product_variant_two','product_variant_three','price','stock','product_id'
    ];

    public function products()
    {
        return $this->hasOne('App\Models\Product','id', 'product_id');
    }

    public function productvariantsone()
    {
        return $this->hasMany('App\Models\ProductVariant','id', 'product_variant_one');
    }

    public function productvariantstwo()
    {
        return $this->hasMany('App\Models\ProductVariant','id', 'product_variant_two');
    }

    public function productvariantsthree()
    {
        return $this->hasMany('App\Models\ProductVariant','id', 'product_variant_three');
    }
}
