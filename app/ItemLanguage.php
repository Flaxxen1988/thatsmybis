<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLanguage extends Model
{
    protected $fillable = [
        'item_id',
        'language',
        'name'
    ];

    public function item(){
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}
