<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recipe extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'ingredient',
        'description',
    ];
}