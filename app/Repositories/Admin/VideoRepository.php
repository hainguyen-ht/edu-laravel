<?php
namespace App\Repositories\Admin;
use App\Video;

class VideoRepository{

    protected $model;

    public function __construct(Video $Mvideo)
    {
        $this->model = $Mvideo;
    }


    public function getInfoBy($key,$value,$arr)
    {
        $data = $this->model->select($arr)->where($key, $value)->first()->toArray();
//dd($data);
        return $data;
    }

    public function insert($data)
    {
        return $this->model->insertGetId($data);
    }

    public function updateBy($key, $value,$arr){
        $video = $this->model->findOrFail($value);
        if($video){
            $this->model->where($key, $value)->update($arr);
            return true;
        }else{
            return false;
        }
    }
}
?>
