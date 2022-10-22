<?php

namespace App\Modules\Robots\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductKeys extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public $table = 'product_keys';

    public $casts = [
        'details' => 'array'
    ];

    protected static function newFactory()
    {
        return \App\Modules\Robots\Database\factories\ProductKeysFactory::new();
    }

    public function subscribe()
    {
        return $this->belongsTo('App\Modules\Robots\Entities\Subscribe', 'subscribe_id', 'id');
    }
}