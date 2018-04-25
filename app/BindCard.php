<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BindCard extends Model
{
    protected $table = 'user_cards';
    protected $fillable = [
        'user_id', 'card_no'
    ];

}
