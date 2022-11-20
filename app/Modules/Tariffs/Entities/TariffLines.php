<?php

namespace App\Modules\Tariffs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TariffLines extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    public $table = 'tariff_lines';

    public $casts = [
        'details' => 'json',
    ];

    protected static function newFactory()
    {
        return \App\Modules\Tariffs\Database\factories\TariffLinesFactory::new();
    }

    public function tariffs()
    {
        return $this->hasMany('App\Modules\Tariffs\Entities\Tariff', 'tariff_line', 'id');
    }
}
