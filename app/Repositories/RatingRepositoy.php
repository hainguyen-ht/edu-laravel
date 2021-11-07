<?php
namespace App\Repositories;
use App\Rating;

class RatingRepositoy{
    protected $model;

    public function __construct(Rating $Mrating)
    {
        $this->model = $Mrating;
    }

    public function insert($data)
    {
        return $this->model->insertGetId($data);
    }

    public function getBy($condition)
    {
        $data = $this->model->where($condition)->orderBy('id','DESC')->get()->toArray();
        return $data;
    }

}
?>
