<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\AccountRepository;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    protected $accounRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function create_submit(Request $req){
        $checkEmail = $this->accountRepository->checkRegister('email', $req->email);
        $checkPhone = $this->accountRepository->checkRegister('phone', $req->phone);
        if($checkEmail > 0){
            $response = [
                'status'    => 2,
                'message'   => 'Email đã tồn tại!'
            ];
        }else if($checkPhone > 0){
            $response = [
                'status'    => 3,
                'message'   => 'Số điện thoại đã tồn tại!'
            ];
        }else{
            $data = [
                'name' => $req->name,
                'phone' => $req->phone,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'created_at' => time()
            ];
            $insert_id = $this->accountRepository->insert($data);

            if($insert_id > 0){
                $response = [
                    'status'    => 1,
                    'message'   => 'Success!'
                ];
            }else{
                $response = [
                    'status'    => 0,
                    'message'   => 'Thêm mới thất bại!'
                ];
            }
        }
        return response()->json($response);
    }
    public function edit_submit(Request $req){
        $data = [
            'name' => $req->name,
            'phone' => $req->phone,
            'updated_at' => time()
        ];
        $result = $this->accountRepository->updateBy('id',$req->id,$data);

        if($result){
            $response = [
                'status'    => 1,
                'message'   => 'Cập nhật thành công!'
            ];
        }else{
            $response = [
                'status'    => 0,
                'message'   => 'Cập nhật thất bại!'
            ];
        }
        return response()->json($response);
    }
}
