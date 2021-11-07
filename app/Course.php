<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';

    protected $primaryKey = 'c_id';

    protected $fillable = ['cate_id','author','c_name','c_description','c_will_learn','c_content','c_want','c_coin','c_image','created_at','updated_at'];

    public $timestamps = false;

//    public function getCategory(){
//        return $this->hasOne(Category::class,'cate_id','id');
//    }

    public function getdata(){
        return $this->all();
    }
}
