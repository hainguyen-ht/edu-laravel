<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'user';

    protected $fillable = ['name', 'phone','email','password','avatar','created_at'];

    public $timestamps = false;
}
