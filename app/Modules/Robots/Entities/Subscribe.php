<?php

namespace App\Modules\Robots\Entities;

use App\Modules\Tariffs\Entities\Tariff;
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

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function productKey($uuid)
    {
        return ProductKeys::query()->where('subscribe_id', $uuid)->first() ?? null;
    }

    public function getTariffAttribute()
    {
        return Tariff::find($this->details['tariff']);
    }
}