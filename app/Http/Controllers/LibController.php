<?php

namespace App\Http\Controllers;

use App\Images;
use App\Video;
use Illuminate\Http\Request;

class LibController extends Controller
{
    protected $tbl_images = 'images';
    protected $_data;

    public function images(){
        $this->_data['images'] = Images::orderBy('id','DESC')->get();

        return view('admin.lib.images')->with($this->_data);
    }

    public function videos(){
        $this->_data['videos'] = Video::orderBy('id','DESC')->get();

        return view('admin.lib.videos')->with($this->_data);
    }
}
