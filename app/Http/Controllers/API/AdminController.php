<?php

namespace App\Http\Controllers\API;

use App\Images;
use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\AccountRepository;
use App\Repositories\Admin\NotifyRepository;

class AdminController extends Controller
{
    protected $accountRepository;
    protected $notifyRepository;

    public function __construct(
        AccountRepository $accountRepository,
        NotifyRepository $notifyRepository
    )
    {
        $this->accountRepository = $accountRepository;
        $this->notifyRepository = $notifyRepository;
    }

    public function confirm_recharge(Request $req){
        $old_coin_user = $this->accountRepository->getBy('id', $req->user_id, ['coin'])['coin'];
        $price = floor($req->price/1000) + $old_coin_user;

        $data_user = [
            'coin' => $price
        ];
        $update_coin = $this->accountRepository->updateBy('id', $req->user_id,$data_user);
        if($update_coin){
            $this->notifyRepository->updateBy('id', $req->notify_id, ['type' => 1]);

            $response = [
                'status' => 1,
                'message' => 'Success'
            ];
        }else{
            $response = [
                'status' => 0,
                'message' => 'Xác nhận thất bại'
            ];
        }

        return response()->json($response);
    }

    public function uploadImage(Request $req){
        $image = $req->file('image');
        $extension = $image->extension();
        $img_name = time().".".$extension;

        $image->move(public_path().'/uploads/', $img_name);
        $data = [
            'url' => $img_name
        ];
        $image_uploaded = Images::create($data);
        $getId = $image_uploaded->id ?? 0;
        if($getId > 0){
            return response()->json([
               'status' => 1,
               'message' => 'success'
            ]);
        }
        return response()->json([
           'status' => 0,
            'message' => 'error'
        ]);
    }

    public function saveVideoEmbed(Request $req){
        $data = [
            'title' => $req->title,
            'link'  => $req->url,
            'created_at'=> time()
        ];
        $create_video = Video::create($data);
        $getIdVideo = $create_video->id ?? 0;
        if($getIdVideo > 0){
            return response()->json([
                'status' => 1,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'status' => 0,
            'message' => 'error'
        ]);
    }
}
