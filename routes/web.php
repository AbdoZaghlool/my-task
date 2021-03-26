<?php

use App\Http\Controllers\AdminController\Admin\LoginController;
use App\Http\Controllers\AdminController\AdminController;
use App\Http\Controllers\AdminController\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();
Route::prefix('admin')->namespace('AdminController')->group(function () {
    Route::view('/home', 'admin.home')->name('admin.home');

    Route::get('login', [LoginController::class,'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginController::class,'login'])->name('admin.login.submit');
    Route::get('password/reset', [ForgotPasswordController::class,'showLinkRequestForm'])->name('admin.password.request');
    Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('admin.password.reset');
    Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('admin.password.update');
    Route::post('logout', [LoginController::class,'logout'])->name('admin.logout');

    
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::resource('admins', 'AdminController');
        Route::get('/profile', 'AdminController@my_profile')->name('my_profile');
        Route::post('/profileEdit', 'AdminController@my_profile_edit')->name('my_profile_edit');
        Route::get('/profileChangePass', 'AdminController@change_pass')->name('change_pass');
        Route::post('/profileChangePass', 'AdminController@change_pass_update')->name('change_pass');
        Route::get('/admin_delete/{id}', 'AdminController@admin_delete')->name('admin_delete');

        Route::get('delete/{id}/user', 'UserController@destroy');
        Route::resource('users', 'UserController');

        Route::get('projects', 'HomeController@projects')->name('admin.projects.index');
    });
});

Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/home', function () {
        return view('home');
    });

    Route::get('projects/{project}/delete', 'Website\ProjectController@destroy');
    Route::resource('projects', 'Website\ProjectController');
});