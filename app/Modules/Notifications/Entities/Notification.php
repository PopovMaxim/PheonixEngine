<?php

namespace App\Modules\Notifications\Entities;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [];
    
    public $table = 'notifications';

    protected $casts = [
        'data' => 'json'
    ];

    protected static function newFactory()
    {
        return \App\Modules\Notifications\Database\factories\NotificationFactory::new();
    }

    public static function getIcon($type)
    {
        return match($type) {
            "auth" => 'fas fa-user text-warning',
            "settings.update" => 'fas fa-cogs text-warning',
            "register" => 'fas fa-heart text-danger',
            "register.partner" => 'fas fa-user-plus text-success',
            "transfer.received" => 'fas fa-coins text-info',
            "transfer.successfull" => 'fas fa-coins text-info',
            "refill.successfull" => 'fas fa-coins text-info',
            "withdrawal.successfull" => 'fas fa-coins text-info',
            "binary.add" => 'fas fa-users text-success',
            "support.answer" => 'fas fa-headset text-success',
            "mailing" => 'fas fa-envelope text-info',
        };
    }
}
