<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'name', 'difficult', 'ingredient', 'description', 'image', 'timeset', 'shortdesc'
    ];

    protected $casts = [
        'ingredients' => 'array', // Indicar que se tratará como un array
    ];
}
