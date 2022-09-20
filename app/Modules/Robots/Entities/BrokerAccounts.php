<?php

namespace App\Modules\Robots\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrokerAccounts extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public $table = 'broker_accounts';
    
    protected static function newFactory()
    {
        return \App\Modules\Robots\Database\factories\BrokerAccountsFactory::new();
    }
}
