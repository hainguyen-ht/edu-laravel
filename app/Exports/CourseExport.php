<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CourseExport implements FromCollection, WithHeadings
{
    protected $start;
    protected $limit;

    function __construct($limit, $start) {
        $this->limit = $limit;
        $this->start = $start;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('user_reg_course')->select('user.name','user.email','course.c_name','course.c_coin','user_reg_course.created_at')
            ->join('course','course.c_id','=','user_reg_course.course_id')
            ->join('user','user.id','=','user_reg_course.user_id')
            ->orderBy('created_at','DESC')->skip($this->start)->take($this->limit)->get();
        foreach ($data as $i => $j){
            $data[$i]->created_at = date('d-m-Y', $j->created_at);
        }
        return $data;
    }
    public function headings() :array {
        return ["Tên học viên","Email", "Tên khoá học", "Học phí", "Ngày tham gia"];
    }
}
