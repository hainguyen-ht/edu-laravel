<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\CategoryRepository;

class CategoryController extends Controller
{
    protected $categoryRepository;
    protected $_data;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $req)
    {
        $limit = 5;
        $keyword = $req->keyword ?? '';
        $list_category = $this->categoryRepository->pagination($limit, $keyword);

        if($keyword != ''){
            $list_category->appends(['keyword' => $keyword]);
        }

        $this->_data['list_category'] = $list_category;
        $this->_data['keyword'] = $keyword;
        return view('admin.category.index')->with($this->_data);
    }

    public function create($id = null)
    {
        $category = '';
        if($id !== null){
            $category = $this->categoryRepository->getInfoBy('id',$id, ['id','cate_name']);
        }
        $this->_data['category'] = $category;
        return view('admin.category.create')->with($this->_data);
    }


}
