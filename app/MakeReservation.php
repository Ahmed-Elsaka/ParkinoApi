<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MakeReservation extends Model
{
    protected $table = 'make_reservations';
    protected $fillable = [
        'long',
        'lat',
        'user_id',
        'annually_tier',
        'monthly_tier',
        'daily_tier',
        'hourly_tier',
        'state','RFID_no'
    ];
}
