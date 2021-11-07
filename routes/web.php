<?php
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\AdminController;
//user
Route::get('/login', 'HomeController@login')->name('login');
Route::get('/register','HomeController@register')->name('register');
Route::get('/resetpw', 'HomeController@reset_password')->name('user.reset');
Route::get('/logout', 'HomeController@logout')->name('user.logout');

//sau đăng nhập
Route::group(['prefix' => 'setting'], function (){
    Route::get('/profile', 'UserController@index')->name('user.profile');
    Route::get('/courses', 'UserController@courses')->name('user.courses');
    Route::get('/change-pass', 'UserController@change_pass')->name('user.change_pass');
    Route::get('/recharge', 'UserController@recharge')->name('user.recharge');
    Route::get('/update', 'UserController@update')->name('user.update');
});


//home
Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/course', 'HomeController@course')->name('course');
Route::get('/detail/{id}', 'HomeController@detail')->name('detail');
Route::get('/learning/{c}/{v}', 'HomeController@learning')->name('learning')->middleware('auth');

//admin
Route::get('admin/login', 'AdminController@login')->name('admin.login');
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function(){
    Route::get('/','AdminController@index')->name('admin');
    //học viên
    Route::get('/account','AccountController@index')->name('admin.account.index');
    Route::get('/account/create','AccountController@create')->name('admin.account.create');
    Route::get('/account/edit/{id}','AccountController@create')->name('admin.account.edit');
    //danh mục
    Route::get('/category','CategoryController@index')->name('admin.category.index');
    Route::get('/category/create','CategoryController@create')->name('admin.category.create');
    Route::get('/category/edit/{id}','CategoryController@create')->name('admin.category.edit');
    //khoá học
    Route::get('/course','CourseController@index')->name('admin.course.index');
    Route::get('/course/create','CourseController@create')->name('admin.course.create');
    Route::get('/course/edit/{id}','CourseController@create')->name('admin.course.edit');
    //quản lý chung
    Route::get('/list/recharge','AdminController@recharge')->name('admin.manager.recharge');
    Route::get('/list/course','AdminController@course')->name('admin.manager.course');
    //thư viện
    Route::get('/lib/images','LibController@images')->name('admin.lib.images');
    Route::get('/lib/videos','LibController@videos')->name('admin.lib.videos');
});

//ajax
Route::group(['prefix' => 'ajax'], function() {
    Route::post('admin/login',[AuthController::class,'login'])->name('ajax.admin.login');
    //account
    Route::post('admin/account/create',[AccountController::class,'create_submit'])->name('ajax.admin.account.create');
    Route::post('admin/account/edit',[AccountController::class,'edit_submit'])->name('ajax.admin.account.edit');
    //category
    Route::post('admin/category/create',[CategoryController::class,'create_submit']);
    Route::post('admin/category/edit',[CategoryController::class,'edit_submit']);
    //course
    Route::post('admin/course/create',[CourseController::class,'create_submit']);
    Route::post('admin/course/edit',[CourseController::class,'edit_submit']);
    //quản lý chung
    Route::post('admin/manager/recharge',[AdminController::class,'confirm_recharge'])->name('ajax.admin.manager.recharge');
    //lib
    Route::post('admin/lib/images',[AdminController::class,'uploadImage'])->name('ajax.admin.lib.images');
    Route::post('admin/lib/videos',[AdminController::class,'saveVideoEmbed'])->name('ajax.admin.lib.videos');



    //user
    Route::post('user/login',[AuthController::class,'user_login'])->name('ajax.user.login');
    Route::post('user/register',[AuthController::class,'user_register'])->name('ajax.user.register');
    Route::post('user/course',[AuthController::class,'user_course'])->name('ajax.user.course');
    Route::post('user/comment',[AuthController::class,'user_comment'])->name('ajax.user.comment');
    //user sau đăng nhập
    Route::post('user/setstatus',[AuthController::class,'setstatus'])->name('ajax.user.setstatus');
    Route::post('user/rating',[AuthController::class,'rating'])->name('ajax.user.rating');
    Route::post('user/changepass',[AuthController::class,'change_pass'])->name('ajax.user.changepass');
    Route::post('user/update',[AuthController::class,'update'])->name('ajax.user.update');
    Route::post('user/update-avt',[AuthController::class,'update_avt'])->name('ajax.user.update-avt');
    Route::post('user/recharge',[AuthController::class,'recharge'])->name('ajax.user.recharge');
    //import
    Route::post('course/import', [CourseController::class,'importCsv'])->name('ajax.course.import');
});


//import, export

