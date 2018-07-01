<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OwnerModel extends Model
{
    protected $table = 'owners';
    protected $fillable = [
        'garage_id', 'garage_points', 'ssd', 'name', 'email', 'phone_number',
    ];
}
