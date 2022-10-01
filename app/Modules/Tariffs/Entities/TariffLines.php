<?php

namespace App\Modules\Tariffs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TariffLines extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public $table = 'tariff_lines';

    protected static function newFactory()
    {
        return \App\Modules\Tariffs\Database\factories\TariffLinesFactory::new();
    }
}
