<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'offer_product')->withPivot('product_quantity');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
