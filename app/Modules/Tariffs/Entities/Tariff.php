<?php

namespace App\Modules\Tariffs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tariff extends Model
{
    use HasFactory;

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
    
    protected static function newFactory()
    {
        return \App\Modules\Tariffs\Database\factories\TariffFactory::new();
    }
}
