<?php
    function getListVideos($str_id){
        $arr_id = explode(',',$str_id);
        $video = new \App\Video();
        $data = $video->whereIn('id',$arr_id)->get();
        return $data;
    }
    function getCourseByCate($cate_id){
        $courses = new \App\Course();
        $data = $courses->where('cate_id',$cate_id)->get()->toArray();
        return $data;
    }
    function convertCoin($coin){
        $html = ' coin';
        $coin = ($coin > 0) ? $coin.$html : 'Miễn phí';
        return $coin;
    }
    function countUserCourse($key,$value){
        $count = DB::table('user_reg_course')->where($key,$value)->count();
        return $count;
    }
    function timeComment($second){
        $time = time() - $second;
        $convert_time = round($time/60);
        $html = $convert_time . ' phút ';
        if($convert_time > 59){
            $convert_time = round($convert_time/60);
            $html = $convert_time . ' giờ ';
        }
        if($convert_time > 24){
            $convert_time = round($convert_time/24);
            $html = $convert_time . ' ngày ';
        }
        return $html;
    }
    function convertDate($time){
        return date("d/m/Y");
    }
    function filterPrice($string){
        $arr = explode( '[',$string);
        $price = $arr[1];
        $price = substr($price,0,-1);
        return $price;
    }

    function convertVote($star_avg){
        $str = 'Chưa có đánh giá';
        if($star_avg !== null){
            $star_avg = round($star_avg,1);
            $str = $star_avg . '/ 5';
        }
        return $str;
    }

    function getAvatarUser($id){
        $img = DB::table('user')->select('avatar')->where('id', $id)->first();
        $img = $img->avatar;
        $url = asset('uploads/avatar/'.$img);
        return $url;
    }

?>
