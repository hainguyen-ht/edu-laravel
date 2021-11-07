<?php

namespace App\Imports;

use App\Category;
use App\Course;
use App\Repositories\Admin\CategoryRepository;
use App\Video;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class CourseImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row){
            if($index == 0) continue;
            if($this->checkCategory($row[0])){
                $videos = $this->getIdVideoByUrls($row[8]);
                $data = [
                    'cate_id' => $row[0]."",
                    'author'  => $row[1]."",
                    'c_name'  => $row[2]."",
                    'c_description' => $row[3]."",
                    'c_will_learn' => $row[4]."",
                    'c_want'    => $row[5]."",
                    'c_coin'    => $row[6]."",
                    'c_image'   => $row[7]."",
                    'c_content'   => $videos."",
                    'created_at' => time()
                ];
                Course::create($data);
            }
        }
    }

    private function getIdVideoByUrls($list_url){
        $arr_url = explode("|",$list_url);
        $result = '';
        foreach ($arr_url as $url){
            $id = Video::where('link','like', '%'.$url.'%')->first()->id;
            $result .= ($id . ',');
        }
        return substr($result,0, strlen($result) - 1);
    }
    private function checkCategory($id){
        try{
            Category::where('id', $id)->first()->id;
            return true;
        }catch (\Exception $exception){
            Log::error("check category --- ".$exception->getMessage());
            return false;
        }
    }
}
