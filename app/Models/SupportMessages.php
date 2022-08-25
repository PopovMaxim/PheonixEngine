<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessages extends Model
{
    use HasFactory;

    public $guarded = [];

    public $table = 'support_messages';

    public $casts = [
        'created_at' => 'datetime'
    ];
}
