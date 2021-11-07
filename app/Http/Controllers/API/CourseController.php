<?php

namespace App\Http\Controllers\API;

use App\Imports\CourseImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\VideoRepository;
use App\Repositories\Admin\CourseRepository;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    protected $videoRepository;

    protected $courseRepository;

    public function __construct(VideoRepository $videoRepository,CourseRepository $courseRepository)
    {
        $this->videoRepository = $videoRepository;
        $this->courseRepository = $courseRepository;
    }

    public function create_submit(Request $req)
    {
        $list_title = explode(',',$req->title);
        $list_durations = explode(',',$req->durations);
        $list_link = explode(',',$req->link);
        $list_video = [];
        for ($i = 0; $i < count($list_title); $i++){
            $data_video = [
                'title' => $list_title[$i],
                'link'  => $list_link[$i],
                'durations' => $list_durations[$i],
                'created_at' => time()
            ];
            $insert_video_id = $this->videoRepository->insert($data_video);
            $list_video[] = $insert_video_id;
        }

        $list_content = implode(',',$list_video);
        //upload image
        $file = $req->file('image');
        $img_name = $file->getClientOriginalName();
        $file->move(public_path().'/uploads/', $img_name);

        $data_course = [
            'cate_id'       => $req->category,
            'c_name'        => $req->name,
            'author'        => $req->author,
            'c_coin'        => $req->coin,
            'c_content'     => $list_content,
            'c_description' => $req->des,
            'c_will_learn'  => $req->will,
            'c_want'        => $req->want,
            'c_image'       =>$img_name,
            'created_at'    => time()
        ];
        $insert_course_id = $this->courseRepository->insert($data_course);
        if($insert_video_id > 0){
            $response = [
                'status' => 1,
                'message' => 'Success'
            ];
        }else{
            $response = [
                'status' => 0,
                'message' => 'Thêm mới thất bại!'
            ];
        }
        return response()->json($response);
    }

    public function edit_submit(Request $req){
        $list_title = explode(',',$req->title);
        $list_durations = explode(',',$req->durations);
        $list_link = explode(',',$req->link);
        $list_video_id = explode(',',$req->list_video);
        $list_video = [];
        for ($i = 0; $i < count($list_title); $i++){
            $data_video = [
                'title' => $list_title[$i],
                'link'  => $list_link[$i],
                'durations' => $list_durations[$i]
            ];
            if($list_video_id[$i] == 'null'){
                //insert
                $data_video['created_at'] = time();
                $insert_video_id = $this->videoRepository->insert($data_video);
            }else{
                //update
                $data_video['updated_at'] = time();
                $this->videoRepository->updateBy('id',$list_video_id[$i],$data_video);
                $insert_video_id = $list_video_id[$i];
            }
            $list_video[] = $insert_video_id;
        }
        $list_content = implode(',',$list_video);
        $data_course = [
            'cate_id'       => $req->category,
            'c_coin'        => $req->coin,
            'c_content'     => $list_content,
            'c_description' => $req->des,
            'c_will_learn'  => $req->will,
            'c_want'        => $req->want,
            'updated_at'    => time()
        ];
        $update_course = $this->courseRepository->updateBy('c_id',$req->id,$data_course);
        if($update_course){
            $response = [
                'status' => 1,
                'message' => 'Success'
            ];
        }else{
            $response = [
                'status' => 0,
                'message' => 'Cập nhật thất bại!'
            ];
        }
        return response()->json($response);
    }

    public function importCsv(Request $request){
        try{
            Excel::import(new CourseImport(), request()->file('file'));
            return response()->json([
                'status' => 1,
                'message' => 'success'
            ]);

        }catch (\Exception $exception){
            Log::error("error import ---- ".$exception->getMessage());
            return response()->json([
                'status' => 0,
                'message' => 'import error'
            ]);
        }
    }
}
