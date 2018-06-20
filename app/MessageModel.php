<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageModel extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'user_id',
        'name',
        'message'];

    //
}
