<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'purchaser_id', 'seller_id'];

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function purchaser(){
        return $this->belongsTo(User::class);
    }

    public function seller(){
        return $this->belongsTo(User::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
