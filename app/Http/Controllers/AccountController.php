<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use App\Repositories\Admin\AccountRepository;

class AccountController extends Controller
{
    protected $_data;
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function index(Request $req)
    {
        $limit = 10;
        $keyword = $req->keyword ?? '';
        $list_account = $this->accountRepository->pagination($limit, $keyword);
        if($keyword != ''){
            $list_account->appends(['keyword' => $keyword]);
        }

        $this->_data['keyword'] = $keyword;
        $this->_data['list_account'] = $list_account;

        return view('admin.account.index')->with($this->_data);
    }

    public function create($id = null)
    {
        $accout = '';
        if($id !== null){
            $accout = $this->accountRepository->getBy('id',$id, ['id','name','phone','email']);
        }
        $this->_data['account'] = $accout;
        return view('admin.account.create')->with($this->_data);
    }

}
