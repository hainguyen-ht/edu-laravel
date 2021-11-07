<?php
namespace App\Repositories\Admin;
use App\Category;

class CategoryRepository{

    protected $model;

    public function __construct(Category $Mcategory)
    {
        $this->model = $Mcategory;
    }

    public function getAll(){
        $data = $this->model->get()->toArray();
        return $data;
    }

    public function pagination($limit,$keyword)
    {
        $data = $this->model->orderBy('id', 'DESC')
                            ->where('cate_name', 'like', '%'.$keyword.'%')->paginate($limit);
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
    public function getCourse(){
        $data = $this->model->select('course.c_id','course.c_name','category.*')
                            ->join('course','course.cate_id','=','category.id')
                            ->get()->toArray();
        return $data;
    }

    public function countCategory(){
        $data = $this->model->all()->count();
        return $data;
    }
}
?>
