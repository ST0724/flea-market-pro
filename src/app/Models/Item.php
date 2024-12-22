<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
        'condition_id',
        // 'category_id',
        'seller_id',
        'purchaser_id'
    ];

    // public function category(){
    //     return $this->belongsTo(Category::class);
    // }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function purchaser(){
        return $this->belongsTo(User::class, 'purchaser_id');
    }

    public function scopeKeywordSearch($query, $keyword){
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
    }
    
}
