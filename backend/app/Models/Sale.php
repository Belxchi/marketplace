<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['offer_id', 'offer_quantity', 'sale_date'];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
