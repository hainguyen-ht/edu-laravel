<?php
namespace App\Repositories;
use App\Comment;

class CommentRepository{

    protected $model;

    public function __construct(Comment $Mcomment)
    {
        $this->model = $Mcomment;
    }

    public function insert($data)
    {
        return $this->model->insertGetId($data);
    }
    public function getBy($condition){
        $data = $this->model->where($condition)->orderBy('id','DESC')->get()->toArray();
        return $data;
    }
    public function getComment($user_id,$video_id){
        $data = $this->model->select('comment.*','user.name')
                            ->join('user','user.id', '=','comment.user_id')
                            ->orderBy('comment.id','DESC')
                            ->where('video_id',$video_id)
                            ->get()
                            ->toArray();
        return $data;
    }
}
?>
