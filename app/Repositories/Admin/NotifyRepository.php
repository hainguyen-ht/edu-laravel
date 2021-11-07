<?php
namespace App\Repositories\Admin;
use App\Notify;

class NotifyRepository{

    protected $model;

    public function __construct(Notify $Mnotify)
    {
        $this->model = $Mnotify;
    }

    public function getInfoBy($key,$value,$arr)
    {
        $data = $this->model->select($arr)->where($key, $value)->first()->toArray();
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

    public function getListNotify($limit, $keyword){
        $data = $this->model->select('notify.*','user.name','user.email')
                            ->join('user','user.id', '=', 'notify.sender')
                            ->where('receiver', NULL)
                            ->where(function ($q) use ($keyword){
                                $q->where('user.name', 'like', '%'.$keyword.'%');
                                $q->orWhere('user.email', 'like', '%'.$keyword.'%');
                            })
                            ->orderBy('type','ASC')
                            ->orderBy('id','DESC')->paginate($limit);
        return $data;
    }
    public function getListBy($condition, $limit){
        $data = $this->model->where($condition)
                            ->orderBy('id', 'DESC')->paginate($limit);
        return $data;
    }
}
?>
