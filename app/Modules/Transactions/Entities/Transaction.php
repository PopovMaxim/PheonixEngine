<?php

namespace App\Modules\Transactions\Entities;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, Uuid;

    public $statuses = [
        'new' => 'Новая',
        'pending' => 'Обработка',
        'completed' => 'Исполнено',
        'canceled' => 'Отмена'
    ];

    public $types = [
        'buy' => 'Покупка',
        'line_bonus' => 'Линейный маркетинг',
        'refill' => 'Пополнение',
        'withdrawal' => 'Выплата',
        'transfer' => 'Перевод',
    ];

    protected $casts = [
        'details' => 'json'
    ];

    protected $guarded = [];

    public $table = 'transactions';
    
    protected static function newFactory()
    {
        return \App\Modules\Transactions\Database\factories\TransactionFactory::new();
    }

    public function getFormattedAmountAttribute()
    {
        $amount = number_format($this->amount / 100, 2);

        $prefix = '+';
        $postfix = '₽';

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

    public function getObfuscatedIdAttribute()
    {
        return substr($this->id, 0, 5) . '*****' . substr($this->id, -5);
    }

    public function getTranslatedTypeAttribute()
    {
        return $this->types[$this->type];
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
}
