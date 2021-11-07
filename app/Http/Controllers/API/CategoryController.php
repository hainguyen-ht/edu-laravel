<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\CategoryRepository;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create_submit(Request $req)
    {
        $data = [
            'cate_name' => $req->name,
            'created_at' => time()
        ];
        $insert_id = $this->categoryRepository->insert($data);
        if($insert_id > 0){
            $response = [
                'status' => 1,
                'message' => 'Thêm mới thành công!'
            ];
        }else{
            $response = [
                'status' => 0,
                'message' => 'Thêm mới thất bại!'
            ];
        }
        return response()->json($response);
    }

    public function edit_submit(Request $req)
    {
        $data = [
            'cate_name' => $req->name,
            'updated_at' => time()
        ];
        $result = $this->categoryRepository->updateBy('id',$req->id, $data);
        if($result > 0){
            $response = [
                'status' => 1,
                'message' => 'Cập nhật thành công!'
            ];
        }else{
            $response = [
                'status' => 0,
                'message' => 'Cập nhật thất bại!'
            ];
        }
        return response()->json($response);
    }
}
