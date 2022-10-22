<?php

namespace App\Modules\Faq\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Items extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $table = 'faq_items';
    
    protected static function newFactory()
    {
        return \App\Modules\Faq\Database\factories\ItemsFactory::new();
    }
}
