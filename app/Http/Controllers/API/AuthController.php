<?php
namespace App\Http\Controllers\API;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\AuthRepository;
use App\Repositories\Admin\AccountRepository;
use App\Repositories\Admin\CourseRepository;
use App\Repositories\Admin\UserCourseRepository;
use App\Repositories\CommentRepository;
use App\Repositories\RatingRepositoy;
use App\Repositories\Admin\NotifyRepository;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $authRepository;
    private $userRepository;
    private $courseRepository;
    private $userCourseRepository;
    private $commentRepository;
    private $ratingRepositoy;
    private $notifyRepository;

    public function __construct(
        AuthRepository $authRepository,
        AccountRepository $userRepository,
        CourseRepository $courseRepository,
        UserCourseRepository $userCourseRepository,
        CommentRepository $commentRepository,
        RatingRepositoy $ratingRepositoy,
        NotifyRepository $notifyRepository
    )
    {
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
        $this->userCourseRepository = $userCourseRepository;
        $this->commentRepository = $commentRepository;
        $this->ratingRepositoy = $ratingRepositoy;
        $this->notifyRepository = $notifyRepository;
    }

    //admin login
    public function login(Request $req){
        $array = [
            'email' => $req->email,
            'password' => $req->password
        ];
        if(Auth::guard('admin')->attempt($array)){
            $response = [
                'status' => 1,
                'message' => 'Đăng nhập thành công!'
            ];
        }else{
            $response = [
                'status' => 0,
                'message' => 'Sai tên tài khoản hoặc mật khẩu!'
            ];
        }
        return response()->json($response);
    }
    //user
    public function user_login(Request $req){
        $array = [
            'email' => $req->email,
            'password' => $req->password
        ];
        if(Auth::attempt($array)){
            $response = [
                'status' => 1,
                'message' => 'Đăng nhập thành công!'
            ];
        }else{
            $response = [
                'status' => 0,
                'message' => 'Sai tên tài khoản hoặc mật khẩu!'
            ];
        }

        return response()->json($response);
    }

    public function user_register(Request $req){
        $checkEmail = $this->userRepository->checkRegister('email', $req->email);

        if($checkEmail > 0){
            $response = [
                'status' => 2,
                'message' => 'Địa chỉ email này đã tồn tại!'
            ];
        }else{
            $array = [
                'name'       => $req->name,
                'email'      => $req->email,
                'password'   => Hash::make($req->password),
                'created_at' => time()
            ];
            $insert_id = $this->userRepository->insert($array);
            if($insert_id > 0){
                $response = [
                    'status' => 1,
                    'message' => 'Đăng ký thành công!'
                ];
            }else{
                $response = [
                    'status' => 0,
                    'message' => 'Đăng ký thất bại!'
                ];
            }
        }

        return response()->json($response);
    }

    public function user_course(Request $req){
        $user_id = $req->user_id;
        $course_id = $req->course_id;

        $user_info = $this->userRepository->getBy('id',$user_id,['coin']);
        $user_coin = $user_info['coin'] ?? 0;
        $course_info = $this->courseRepository->getInfoBy('c_id',$course_id,['c_coin']);
        $course_coin = $course_info['c_coin'];

        $checkUserCourse = $this->userCourseRepository->checkRegCourse($user_id,$course_id);

        if(!$checkUserCourse){
            if($user_coin >= $course_coin){
                $data_update_user = [
                    'coin'          => $user_coin - $course_coin,
                    'updated_at'    => time()
                ];
                $data_update_user_reg_course = [
                    'user_id' => $user_id,
                    'course_id' => $course_id,
                    'created_at' => time(),
                ];
                $this->userRepository->updateBy('id',$user_id,$data_update_user);
                $this->userCourseRepository->insert($data_update_user_reg_course);
                $response = [
                    'status' => 1,
                    'message' => 'Đăng ký thành công!'
                ];
            }else{
                $response = [
                    'status' => 0,
                    'message' => 'Số coin trong ví không đủ!'
                ];
            }
        }else{
            $response = [
                'status' => 2,
                'message' => 'Bạn đã đăng ký khoá học này rồi!'
            ];
        }

        return response()->json($response);
    }

    public function user_comment(Request $req){
        $data = [
            'user_id' => $req->user_id,
            'video_id' => $req->video_id,
            'content' => $req->comment,
            'created_at' => time()
        ];
        $insert_id = $this->commentRepository->insert($data);
        if($insert_id > 0){
            $response = [
                'status' => 1,
                'message' => 'success'
            ];
        }else{
            $response = [
                'status' => 0,
                'message' => 'Bình luận thất bại'
            ];
        }

        return response()->json($response);
    }

    public function setstatus(Request $req){
        $condition = [
            'user_id' => $req->user_id,
            'course_id' => $req->course_id
        ];
        $data = [
            'status' => 1,
            'updated_at' => time()
        ];
        $response = [
            'status' => 0,
            'message' => 'Cập nhật trạng thái thất bại!'
        ];

        $result = $this->userCourseRepository->update($condition,$data);

        if($result){
            $response = [
                'status' => 1,
                'message' => 'Cập nhật trạng thái thành công!'
            ];
        }

        return response()->json($response);
    }

    public function rating(Request $req){
        $data = [
            'user_id' => $req->user_id,
            'course_id' => $req->course_id,
            'star'   => $req->star,
            'created_at' => time()
        ];

        $response = [
            'status' => 0,
            'message' => 'Đánh giá khoá học thất bại!'
        ];

        $insert_id = $this->ratingRepositoy->insert($data);

        if($insert_id > 0){
            $response = [
                'status' => 1,
                'message' => 'Đánh giá khoá học thành công!'
            ];
        }

        return response()->json($response);
    }

    public function change_pass(Request $req){

        $old_password = $req->password;
        if(Hash::check($old_password, Auth::user()->password)){
            $data = [
                'password' => Hash::make($req->new_password),
                'updated_at' => time()
            ];
            $result = $this->userRepository->updateBy('id', Auth::id(),$data);
            if($result){
                $response = [
                    'status' => 1,
                    'message' => 'Đổi mật khẩu thành công!'
                ];
            }else{
                $response = [
                    'status' => 0,
                    'message' => 'Đổi mật khẩu thất bại!'
                ];
            }
        }else{
            $response = [
                'status' => 2,
                'message' => 'Sai mật khẩu đăng nhập!'
            ];
        }


        return response()->json($response);
    }

    public function update(Request $req){
        $data = [
            'name' => $req->name,
            'phone'=> $req->phone,
            'updated_at'=> time()
        ];
        $response = [
            'status' => 0,
            'message' => 'Cập nhật thất bại!'
        ];
        $update = $this->userRepository->updateBy('id',$req->user_id,$data);
        if($update){
            $response = [
                'status' => 1,
                'message' => 'Cập nhật thành công!'
            ];
        }

        return response()->json($response);
    }

    public function recharge(Request $req){
        $data = [
            'sender' => $req->user_id,
            'content' => $req->email . ' Y/c nap tien: ['.$req->price.']',
            'status' => 0,
            'type' => 0,
            'created_at' => time()
        ];
        $response = [
            'status' => 0,
            'message' => 'Gửi yêu cầu nạp tiền thất bại!'
        ];
        $insert_id = $this->notifyRepository->insert($data);

        if($insert_id > 0){
            $response = [
                'status' => 1,
                'message' => 'Gửi yêu cầu nạp tiền thành công!'
            ];
        }

        return response()->json($response);
    }

    public function update_avt(Request $req){
        $file = $req->file('avt_user');
        $img_name = $file->getClientOriginalName();

        $file->move(public_path().'/uploads/avatar', $img_name);
        $data = [
            'avatar' => $img_name,
            'updated_at' => time()
        ];
        $update_avt = $this->userRepository->updateBy('id', $req->user_id, $data);
        $response = [
            'status' => 0,
            'message' => 'Cập nhật ảnh đại diện thất bại!'
        ];

        if($update_avt){
            $response = [
                'status' => 1,
                'message' => 'Cập nhật thành công!'
            ];
        }

        return response()->json($response);
    }
}
