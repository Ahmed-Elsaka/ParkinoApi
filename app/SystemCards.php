<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemCards extends Model
{
    protected $table = 'cards';
    protected $fillable = [
        'id','qr_no', 'rfid_no','state'
    ];
}
