<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\CourseRepository;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\VideoRepository;
use App\Repositories\Admin\UserCourseRepository;
use App\Repositories\CommentRepository;
use Auth;

class HomeController extends Controller
{
    protected $_data;
    protected $courseRepository;
    protected $categoryRepository;
    protected $videoRepository;
    protected $userCourseRepository;
    protected $commentRepository;

    public function __construct(
        CourseRepository $courseRepository,
        CategoryRepository $categoryRepository,
        VideoRepository $videoRepository,
        UserCourseRepository $userCourseRepository,
        CommentRepository $commentRepository
    )
    {
        $this->courseRepository = $courseRepository;
        $this->categoryRepository = $categoryRepository;
        $this->videoRepository = $videoRepository;
        $this->userCourseRepository = $userCourseRepository;
        $this->commentRepository = $commentRepository;
    }

    public function index()
    {
        $limit = 10;
        $course = $this->courseRepository->pagination($limit);
        $this->_data['course'] = $course;
        $this->_data['check_page'] = 'index';
        $this->_data['title_page'] = 'F8 - Học lập trình để đi làm!';

        return view('site.index')->with($this->_data);
    }

    public function course(){
        $limit = 10;
        $category = $this->categoryRepository->getAll();
        $course = $this->courseRepository->pagination($limit);
        $this->_data['category'] = $category;
        $this->_data['course'] = $course;
        $this->_data['check_page'] = 'course';
        $this->_data['title_page'] = 'Danh sách khoá học!';

        return view('site.course')->with($this->_data);
    }
    public function detail($course_id){
        $course = $this->courseRepository->detailCourse($course_id);
        $course_name = $course['c_name'];
        $user_course = false;

        if(Auth::check()){
            $user_id = Auth::id();
            $user_course = $this->userCourseRepository->checkRegCourse($user_id,$course_id);
        }

        $this->_data['course'] = $course;
        $this->_data['check_page'] = 'detail';
        $this->_data['user_course'] = $user_course;
        $this->_data['title_page'] = 'Chi tiết khoá học | ' . $course_name;

        return view('site.detail')->with($this->_data);
    }

    public function learning($course_id, $video_id){
        $user_id = Auth::id();
        $user_course = $this->userCourseRepository->checkRegCourse($user_id,$course_id);
        if(!$user_course){
            return redirect('detail/'.$course_id);
        }

        $course = $this->courseRepository->detailCourse($course_id);
        $list_video = getListVideos($course['c_content']);
        $video  = $this->videoRepository->getInfoBy('id',$video_id,['*']);

        $comments = $this->commentRepository->getComment($user_id,$video_id);

        $video_name = $video['title'];

        $this->_data['course'] = $course;
        $this->_data['list_video'] = $list_video;
        $this->_data['video'] = $video;
        $this->_data['comments'] = $comments;
        $this->_data['check_page'] = 'learning';
        $this->_data['title_page'] = $video_name;

        return view('site.learning')->with($this->_data);
    }

    public function login(){
        if(Auth::check()){
            return redirect('/');
        }
        $this->_data['title_page'] = 'Đăng nhập thành viên F8';
        return view('author.login')->with($this->_data);
    }
    public function register(){
        if(Auth::check()){
            return redirect('/');
        }
        $this->_data['title_page'] = 'Đăng ký thành viên F8';
        return view('author.register')->with($this->_data);
    }
    public function reset_password(){
        $this->_data['title_page'] = 'Yêu cầu cấp lại mật khẩu học viên';
        return view('author.reset-password')->with($this->_data);
    }
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }

}
