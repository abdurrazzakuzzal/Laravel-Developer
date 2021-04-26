<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'id', 'variant', 'variant_id', 'product_id'
    ];
}
