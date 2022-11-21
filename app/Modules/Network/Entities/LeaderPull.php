<?php

namespace App\Modules\Network\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaderPull extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public $table = 'leader_pulls';

    public $casts = [
        'started_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    protected static function newFactory()
    {
        return \App\Modules\Network\Database\factories\LeaderPullFactory::new();
    }
}
