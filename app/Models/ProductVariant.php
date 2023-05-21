<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_type',
        'color',
        'size',
        'quantity',
        'price',
        'selling_price',
     ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
