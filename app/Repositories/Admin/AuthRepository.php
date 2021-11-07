<?php
namespace App\Repositories\Admin;
use App\Admin;

class AuthRepository{

    protected $model;

    public function __construct(Admin $Madmin)
    {
        $this->model = $Madmin;
    }

    public function getInfoBy($arr,$email)
    {
        $data = $this->model->select($arr)->where('user_name', $email)->first()->toArray();
        return $data;
    }

}
?>
