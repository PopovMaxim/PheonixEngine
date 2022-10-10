<?php

namespace App\Modules\Robots\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrokerAccounts extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    public $table = 'broker_accounts';

    public $casts = [
        'expires_at' => 'timestamp'
    ];
    
    protected static function newFactory()
    {
        return \App\Modules\Robots\Database\factories\BrokerAccountsFactory::new();
    }

    public function product()
    {
        return $this->belongsTo('App\Modules\Robots\Entities\Product', 'ea_name', 'key');
    }
}
