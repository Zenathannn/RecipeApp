<?php
// app/Models/Recipe.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'recipes';
    protected $primaryKey = 'id_recipe';

    protected $fillable = [
        'username',
        'category',
        'title',
        'description',
        'image_url',
        'image_path' // Tambahkan ini
    ];

    // Method helper untuk mendapatkan gambar
    public function getImageAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return $this->image_url;
    }
}
