<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingArea extends Model
{
    protected $table = 'parkingareas';
    protected $fillable = [
        'id', 'name', 'admin_id', 'owner_ssd', 'long', 'lat', 'slots_no', 'created_at', 'updated_at',
    ];
}
