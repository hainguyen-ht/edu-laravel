<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    public $timestamps = false;

    protected $fillable = ['title','link','durations','created_at'];
}
