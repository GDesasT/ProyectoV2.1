<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CarouselImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'is_active',
    ];

    // Opcional: Si deseas definir una ruta específica para las imágenes almacenadas
    public function getImageUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
