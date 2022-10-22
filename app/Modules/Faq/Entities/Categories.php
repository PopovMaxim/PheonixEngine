<?php

namespace App\Modules\Faq\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public $table = 'faq_categories';

    protected static function newFactory()
    {
        return \App\Modules\Faq\Database\factories\CategoriesFactory::new();
    }

    public function items()
    {
        return $this->hasMany('App\Modules\Faq\Entities\Items', 'category_id', 'id');
    }
}
