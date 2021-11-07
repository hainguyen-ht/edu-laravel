<?php

namespace App\Http\Controllers;

use App\Repositories\Admin\AuthRepository;
use App\Repositories\Admin\NotifyRepository;
use App\Repositories\Admin\CourseRepository;
use App\Repositories\Admin\AccountRepository;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    protected $_data;
    protected $authRepository;
    protected $notifyRepository;
    protected $courseRepository;
    protected $accountRepository;
    protected $categoryRepository;

    public function __construct(
        AuthRepository $authRepository,
        NotifyRepository $notifyRepository,
        CourseRepository $courseRepository,
        AccountRepository $accountRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->authRepository = $authRepository;
        $this->notifyRepository = $notifyRepository;
        $this->courseRepository = $courseRepository;
        $this->accountRepository = $accountRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $user['all'] = $this->accountRepository->countUser();
        $course['all'] = $this->courseRepository->countCourse();
        $category['all'] = $this->categoryRepository->countCategory();


        $this->_data['user'] = $user;
        $this->_data['course'] = $course;
        $this->_data['category'] = $category;
        return view('admin.index')->with($this->_data);
    }

    public function login()
    {
        if(Auth::guard('admin')->check()){
            return redirect('admin');
        }
        return view('admin.auth.login');
    }

    public function recharge(Request $req){
        $limit = 5;
        $keyword = $req->keyword ?? '';

        $list_recharge = $this->notifyRepository->getListNotify($limit, $keyword);
        if($keyword != ''){
            $list_recharge->appends(['keyword' => $keyword]);
        }

        $this->_data['recharge'] = $list_recharge;
        $this->_data['keyword'] = $keyword;

        return view('admin.manager.recharge')->with($this->_data);
    }

    public function course(){
        $list_course = $this->courseRepository->detailCourses();
        $this->_data['list_course'] = $list_course;

        return view('admin.manager.course')->with($this->_data);
    }


}
