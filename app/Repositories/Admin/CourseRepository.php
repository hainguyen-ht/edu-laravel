<?php
namespace App\Repositories\Admin;
use App\Course;

class CourseRepository{

    protected $model;

    public function __construct(Course $Mcourse)
    {
        $this->model = $Mcourse;
    }

    public function getAll(){
        $data = $this->model->get()->toArray();
        return $data;
    }

//    public function pagination($limit)
//    {
//        $data = $this->model->select('course.*','category.cate_name')
//                            ->join('category','category.id','=','course.cate_id')
//                            ->orderBy('course.c_id','DESC')->paginate($limit);
//        return $data;
//    }

    public function pagination($limit,$keyword = ''){
        $data = $this->model->select('course.*','category.cate_name')
                            ->join('category','category.id','=','course.cate_id')
                            ->where('course.c_name', 'like', '%'.$keyword.'%')
                            ->orWhere('category.cate_name', 'like', '%'.$keyword.'%')
                            ->orderBy('course.c_id','DESC')->paginate($limit);
        return $data;
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
        $category = $this->model->findOrFail($value);
        if($category){
            $this->model->where($key, $value)->update($arr);
            return true;
        }else{
            return false;
        }
    }
    public function detailCourse($id){
        $data = $this->model->select('course.*','category.cate_name')
                            ->join('category','category.id','=','course.cate_id')
                            ->where('c_id', $id)->first();
        return $data;
    }

    public function detailCourses(){
        $arr = 'course.c_id,course.c_name,course.c_coin,count(user_reg_course.user_id) as count_user,avg(vote.star) as avg_star';
        $data = $this->model->selectRaw($arr)
                            ->join('user_reg_course', 'user_reg_course.course_id', '=', 'course.c_id','left')
                            ->leftJoin('vote',function ($q){
                                $q->on('vote.user_id', '=', 'user_reg_course.user_id')
                                    ->on('vote.course_id', '=', 'user_reg_course.course_id');
                            })
                            ->groupBy('course.c_id')
                            ->orderBy('count_user', 'DESC')
                            ->orderBy('avg_star', 'DESC')
                            ->get();
        return $data;
    }

    public function countCourse(){
        $data = $this->model->all()->count();
        return $data;
    }
}
?>
