<?php

namespace App\Modules\Robots\Entities;

use App\Modules\Tariffs\Entities\Tariff;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Subscribe extends Model
{
    use HasFactory, Uuid, HasJsonRelationships;

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
    
    public function tariff()
    {
        return $this->belongsTo('App\Modules\Tariffs\Entities\Tariff', 'details->tariff');
    }

    public function key()
    {
        return $this->belongsTo('App\Modules\Robots\Entities\ProductKeys', 'id', 'subscribe_id');
    }
}