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

    public function getSubscribeAttribute()
    {
        return Subscribe::query()->where('id', $this->subscribe_id)->first() ?? null;
    }
}
