<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'building', 'post_code', 'item_id'];

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
