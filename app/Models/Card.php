<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number',
        'expire_date',
        'cvc',
        'name',
        'limit_balance',
        'current_balance',
        'card_flag'
    ];
}
