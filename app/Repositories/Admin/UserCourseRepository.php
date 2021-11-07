<?php
namespace App\Repositories\Admin;
use App\UserCourse;

class UserCourseRepository{

    protected $model;

    public function __construct(UserCourse $Musercourse)
    {
        $this->model = $Musercourse;
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
    public function update($condition, $data)
    {
        $result = false;
        $update = $this->model->where($condition)->update($data);
        if($update){
            $result = true;
        }
        return $result;
    }

    public function checkRegCourse($user_id, $course_id){
        $condition = [
          'user_id'=>$user_id,
          'course_id' => $course_id
        ];
        $data = $this->model->where($condition)->count();
        $data = ($data > 0) ? true : false;
        return $data;
    }
    public function courseByUser($user_id,$limit){
        $data = $this->model->select('user_reg_course.*','course.c_name','vote.star')
                            ->join('course','course.c_id','=','user_reg_course.course_id')
                            ->leftJoin('vote',function ($q){
                                $q->on('vote.user_id', '=', 'user_reg_course.user_id')
                                    ->on('vote.course_id', '=', 'user_reg_course.course_id');
                            })
                            ->where('user_reg_course.user_id', $user_id)
                            ->orderBy('id','DESC')
                            ->paginate($limit);
        return $data;

    }

}
?>
