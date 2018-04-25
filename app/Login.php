<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    //

    protected $table = 'login';
    public $timestamps = false;
   protected $fillable=['email','password'];
    public $incrementing = false;
    public static $snakeAttributes = false;

}
