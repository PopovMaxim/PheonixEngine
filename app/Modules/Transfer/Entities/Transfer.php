<?php

namespace App\Modules\Transfer\Entities;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Transfer extends Model
{
    use HasFactory, Uuid, HasJsonRelationships;

    public $statuses = [
        'pending' => 'Обработка',
        'completed' => 'Исполнено',
        'canceled' => 'Отмена'
    ];

    protected $guarded = [];
    
    public $table = 'transactions';

    protected $casts = [
        'details' => 'json'
    ];

    private $gateways = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'details->sender', 'id');
    }
    
    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'details->receiver', 'id');
    }
    
    public function getFormattedAmountAttribute()
    {
        $amount = number_format($this->amount / 100, 2);

        $prefix = '+';
        $postfix = config('app.internal-currency');

        if ($this->direction == 'outer')
        {
            $prefix = '-';
        }

        return "{$prefix}{$amount} {$postfix}";
    }

    public function getTranslatedStatusAttribute()
    {
        return $this->statuses[$this->status];
    }

    public function getTranslatedTypeAttribute()
    {
        return 'Перевод';
    }

    public function getHtmlStatusAttribute()
    {
        return match($this->status) {
            'new' => '<span class="badge bg-info">'.$this->translated_status.'</span>',
            'pending' => '<span class="badge bg-warning">'.$this->translated_status.'</span>',
            'completed' => '<span class="badge bg-success">'.$this->translated_status.'</span>',
            'canceled' => '<span class="badge bg-secondary">'.$this->translated_status.'</span>',
        };
    }

    protected static function newFactory()
    {
        return \App\Modules\Refill\Database\factories\RefillFactory::new();
    }
}
