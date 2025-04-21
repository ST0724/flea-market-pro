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
        'seller_id',
        'purchaser_id'
    ];

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function purchaser(){
        return $this->belongsTo(User::class, 'purchaser_id');
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function scopeKeywordSearch($query, $keyword){
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
    }

    public function isLikedByUser($user){
        return $user !== null && $this->likes()->where('user_id', $user->id)->exists();
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'categories_items', 'item_id', 'category_id');
    }

    public function transactions(){
        return $this->hasMany(Transaction::class, 'item_id');
    }
}
