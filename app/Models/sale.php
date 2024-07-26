<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total',
        'customer_id',
        'dish_id',
    ];

    // Relación con el modelo Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relación con el modelo Dish
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
