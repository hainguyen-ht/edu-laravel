<?php

namespace App\Http\Controllers;

use Egulias\EmailValidator\Exception\CommaInDomain;
use Illuminate\Http\Request;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\CourseRepository;
use App\Course;

class CourseController extends Controller
{
    protected $_data;
    protected $categoryRepository;
    protected $coursegoryRepository;

    public function __construct(CategoryRepository $categoryRepository,CourseRepository $courseRepository)
    {
        $this->categoryRepository   = $categoryRepository;
        $this->coursegoryRepository = $courseRepository;
    }

    public function index(Request $req)
    {
        $limit = 5;

        $keyword = $req->keyword ?? '';

        $list_course = $this->coursegoryRepository->pagination($limit, $keyword);
        if($keyword != ''){
            $list_course->appends(['keyword' => $keyword]);
        }

        $this->_data['keyword'] = $keyword;
        $this->_data['list_course'] = $list_course;
        return view('admin.course.index')->with($this->_data);
    }

    public function create($id = null)
    {
        $category = $this->categoryRepository->getAll();

        $course = '';
        if($id !== null){
            $course = $this->coursegoryRepository->getInfoBy('c_id', $id, [
                'c_id','c_name','cate_id','author','c_description','c_will_learn','c_content','c_want','c_coin','c_image'
            ]);
        }
        $this->_data['course'] = $course;
        $this->_data['category'] = $category;
        return view('admin.course.create')->with($this->_data);
    }

}
