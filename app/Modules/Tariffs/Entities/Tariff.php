<?php

namespace App\Modules\Tariffs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tariff extends Model
{
    use HasFactory;

    public $table = 'tariffs';

    public static $tariffs = [
        1 => [
            'title' => 'Старт',
            'key' => 'start',
            'price' => 799000,
            'binary' => true,
            'line_marketing' => 1,
            'period' => '1 year',
            'priority' => 3,
        ],
        2 => [
            'title' => 'Стандарт',
            'key' => 'medium',
            'price' => 1299000,
            'binary' => true,
            'line_marketing' => 5,
            'period' => '2 years',
            'priority' => 2,
        ],
        3 => [
            'title' => 'Бизнес',
            'key' => 'business',
            'price' => 2799000,
            'binary' => true,
            'line_marketing' => 10,
            'period' => '5 years',
            'priority' => 1,
        ],
        4 => [
            'title' => 'Профессионал',
            'key' => 'professional',
            'price' => 2999000,
            'binary' => true,
            'line_marketing' => 10,
            'period' => '1 years',
            'priority' => 1,
        ],
    ];

    protected $guarded = [];

    public $casts = [
        'ribbon' => 'json',
        'details' => 'json',
        'sale' => 'json',
        'color' => 'string',
    ];

    public $periods = [
        '1 week' => '1 неделя',
        '2 weeks' => '2 недели',
        '3 weeks' => '3 недели',
        '6 months' => '6 месяцев',
        '9 months' => '9 месяцев',
        '1 year' => '1 год',
        '2 years' => '2 года',
        '3 years' => '3 года',
        '4 years' => '4 года',
        '5 years' => '5 лет',
    ];
    
    protected static function newFactory()
    {
        return \App\Modules\Tariffs\Database\factories\TariffFactory::new();
    }

    public function line()
    {
        return $this->belongsTo('App\Modules\Tariffs\Entities\TariffLines', 'tariff_line', 'id');
    }

    public function getTranslatedPeriodAttribute()
    {
        return $this->periods[$this->period] ?? '';
    }

    public function getResultPriceAttribute()
    {
        if (isset($this->sale['variant']) && $this->sale['variant'] == 'percentage') {
            return $this->price * (100 - $this->sale['sum']) / 100;
        } else if (isset($this->sale['variant']) && $this->sale['variant'] == 'numeric') {
            return $this->price - ($this->sale['sum'] * 100) / 100;
        }

        return $this->price;
    }
}
