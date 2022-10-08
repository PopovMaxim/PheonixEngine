<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmCodes extends Model
{
    use HasFactory;

    public $casts = [
        'details' => 'array'
    ];

    public $guarded = [];

    public $table = 'confirm_codes';
}
