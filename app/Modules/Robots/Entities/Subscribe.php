<?php

namespace App\Modules\Robots\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscribe extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $table = 'transactions';
    
    public $casts = [
        'details' => 'array'
    ];
    
    protected static function newFactory()
    {
        return \App\Modules\Robots\Database\factories\SubscribeFactory::new();
    }

    public function productKey()
    {
        return $this->belongsTo('App\Modules\Robots\Entities\ProductKeys', 'subscribe_id', 'id');
    }
}
