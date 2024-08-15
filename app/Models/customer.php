<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['number','name', 'lastname', 'email', 'enterprise_id'];

    public function enterprise()
{
    return $this->belongsTo(enterprise::class, 'enterprise_id');
}
}
