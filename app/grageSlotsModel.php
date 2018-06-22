<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class grageSlotsModel extends Model
{
    protected $table = 'garagesSlots';
    protected $fillable = [
        'garage_id', 'slot','state'
    ];

}
