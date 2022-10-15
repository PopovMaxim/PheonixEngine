<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class SupportTickets extends Model
{
    use HasFactory, Uuid;

    public $table = 'support_tickets';

    public $guarded = [];

    public static $statuses = [
        'new' => 'Новый',
        'wait_support' => 'Ожидает ответа поддержки',
        'wait_user' => 'Ожидает Вашего ответа',
        'closed' => 'Закрыт'
    ];

    public function subject()
    {
        return $this->belongsTo('\App\Models\SupportSubjects', 'subject_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany('\App\Models\SupportMessages', 'ticket_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'user_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo('\App\Models\User', 'staff_id', 'id');
    }

    public function getStatusAttributesAttribute()
    {
        return match($this->status)
        {
            'new' => [
                'color' => 'warning',
                'text' => self::$statuses[$this->status]
            ],
            'wait_support' => [
                'color' => 'warning',
                'text' => self::$statuses[$this->status]
            ],
            'wait_user' => [
                'color' => 'warning',
                'text' => self::$statuses[$this->status]
            ],
            'closed' => [
                'color' => 'muted',
                'text' => self::$statuses[$this->status]
            ],
        };
    }
}
