<?php

namespace App\Modules\Robots\Entities;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscribe extends Model
{
    use HasFactory, Uuid;

    protected $guarded = [];

    public $table = 'transactions';
    
    public $casts = [
        'details' => 'array'
    ];
    
    protected static function newFactory()
    {
        return \App\Modules\Robots\Database\factories\SubscribeFactory::new();
    }

    public function productKey($uuid)
    {
        return ProductKeys::query()->where('subscribe_id', $uuid)->first() ?? null;
    }
}
