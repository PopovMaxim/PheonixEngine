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

    public $statuses = [
        'new' => 'Новый',
        'in_work' => 'В работе',
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
                'text' => $this->statuses[$this->status]
            ],
            'in_work' => [
                'color' => 'warning',
                'text' => $this->statuses[$this->status]
            ],
            'closed' => [
                'color' => 'success',
                'text' => $this->statuses[$this->status]
            ],
        };
    }
}
