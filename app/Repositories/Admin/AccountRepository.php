<?php
namespace App\Repositories\Admin;
use App\Account;

class AccountRepository{

    protected $model;

    public function __construct(Account $Maccount)
    {
        $this->model = $Maccount;
    }

    public function getAll()
    {
        $data = $this->model->get();
        return $data;
    }

    public function pagination($limit, $keyword)
    {
        $data = $this->model->orderBy('id','DESC')
                            ->where('name', 'like', '%'.$keyword.'%')
                            ->orWhere('phone', 'like', '%'.$keyword.'%')
                            ->orWhere('email', 'like', '%'.$keyword.'%')
                            ->paginate($limit);
        return $data;
    }

    public function getBy($key,$value,$arr)
    {
        $data = $this->model->select($arr)->where($key,$value)->first()->toArray();
        return $data;
    }
    public function insert($data)
    {
        return $this->model->insertGetId($data);
    }
    public function checkRegister($key, $value){
        $data = $this->model->where($key, $value)->count();
        return $data;
    }
    public function updateBy($key, $value,$arr){
        $account = $this->model->findOrFail($value);
        if($account){
            $this->model->where($key, $value)->update($arr);
            return true;
        }else{
            return false;
        }
    }

    public function countUser(){
        $data = $this->model->all()->count();
        return $data;
    }
}
?>
