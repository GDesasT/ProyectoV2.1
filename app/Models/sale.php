<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'customer_id',
        'name',
        'lastName',
        'total',
        'dish_type',
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
