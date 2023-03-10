<?php

namespace App\Modules\Refill\Entities;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refill extends Model
{
    use HasFactory, Uuid;

    public $statuses = [
        'new' => 'Ожидает пополнения',
        'pending' => 'Обработка',
        'completed' => 'Исполнено',
        'canceled' => 'Отмена'
    ];

    public $types = [
        'crypto' => 'Криптовалюты',
    ];

    protected $guarded = [];
    
    public $table = 'transactions';

    protected $casts = [
        'details' => 'array'
    ];

    private $gateways = [];

    public function __construct()
    {
        foreach ($this->types as $key => $value) {
            $this->gateways[$key] = config('wallet.' . $key);
        }
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
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

    public function getHtmlStatusAttribute()
    {
        return match($this->status) {
            'new' => '<span class="badge bg-info">'.$this->translated_status.'</span>',
            'pending' => '<span class="badge bg-warning">'.$this->translated_status.'</span>',
            'completed' => '<span class="badge bg-success">'.$this->translated_status.'</span>',
            'canceled' => '<span class="badge bg-secondary">'.$this->translated_status.'</span>',
        };
    }

    public function getGatewayAttribute()
    {
        $gateway = $this->gateways[$this->details['gateway']['type']];

        return new $gateway($this->details['gateway']['currency']);
    }

    public function getTypeAttribute()
    {
        return $this->details['gateway']['type'] ? $this->types[$this->details['gateway']['type']] : 'Неизвестно';
    }

    public function getCurrencyAttribute()
    {
        return $this->details['gateway']['currency'] ?? 'Неизвестно';
    }

    protected static function newFactory()
    {
        return \App\Modules\Refill\Database\factories\RefillFactory::new();
    }
}
