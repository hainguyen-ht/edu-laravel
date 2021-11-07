<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\UserCourseRepository;
use App\Repositories\Admin\NotifyRepository;
use Auth;

class UserController extends Controller
{
    protected $_data;
    protected $userCourseRepository;
    protected $notifyRepository;

    public function __construct(
        UserCourseRepository $userCourseRepository,
        NotifyRepository $notifyRepository
    )
    {
        $this->middleware('auth');
        $this->userCourseRepository = $userCourseRepository;
        $this->notifyRepository = $notifyRepository;
    }

    public function index(){
        $user = Auth::user();
        $user_id = Auth::id();
        $limit = 5;
        $condition = [
            'sender' => $user_id,
            'receiver' => NULL
        ];
        $notify = $this->notifyRepository->getListBy($condition, $limit);

        $this->_data['user'] = $user;
        $this->_data['notify_recharge'] = $notify;
        $this->_data['title_page'] = 'Thông tin cá nhân';
        $this->_data['check_page'] = 'profile';

        return view('site.user.profile')->with($this->_data);
    }

    public function courses(){
        $limit = 5;
        $courses = $this->userCourseRepository->courseByUser(Auth::id(),$limit);

        $this->_data['courses'] = $courses;

        $this->_data['title_page'] = 'Danh sách khoá học đã mua';
        $this->_data['check_page'] = 'user_course';
        return view('site.user.courses')->with($this->_data);
    }

    public function change_pass(){
        $this->_data['title_page'] = 'Đổi mật khẩu';
        $this->_data['check_page'] = 'change_password';
        return view('site.user.change-password')->with($this->_data);
    }

    public function recharge(){
        $user = Auth::user();

        $this->_data['user'] = $user;
        $this->_data['title_page'] = 'Gửi yêu cầu nạp tiền';
        $this->_data['check_page'] = 'recharge';
        return view('site.user.recharge')->with($this->_data);
    }

    public function update(){
        $user = Auth::user();

        $this->_data['user'] = $user;
        $this->_data['title_page'] = 'Cập nhật hồ sơ cá nhân';
        $this->_data['check_page'] = 'update';
        return view('site.user.update')->with($this->_data);
    }
}
