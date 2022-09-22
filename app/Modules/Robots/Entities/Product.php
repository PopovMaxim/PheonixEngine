<?php

namespace App\Modules\Robots\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public $table = 'product';

    protected static function newFactory()
    {
        return \App\Modules\Robots\Database\factories\ProductVersionsFactory::new();
    }
}
