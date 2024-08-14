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
        'enterprise_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }
}
