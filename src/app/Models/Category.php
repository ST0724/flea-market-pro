<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function items(){
        return $this->belongsToMany(Category::class, 'categories_items', 'category_id', 'item_id');
    }
}
