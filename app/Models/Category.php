<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Habilitar asignación masiva en el modelo.
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'descripcion'];

}
