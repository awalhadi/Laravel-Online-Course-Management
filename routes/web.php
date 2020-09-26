<?php

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

Route::get('/', 'FrontendController@index');
// user section

Auth::routes();
Route::name('user.')->prefix('user')->group(function(){

    Route::middleware('auth')->group(function(){
        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send_verify_code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify_email');

        Route::middleware('ckstatus')->group(function(){
            Route::get('/home', 'UserController@index')->name('home');

            // course
            Route::get('/new/course/{id}', 'UserCourse@request_course')->name('request.course');
            Route::get('/course/drop/{id}', 'UserCourse@drop_course')->name('drop.course');

        });

    });
});


// admin section

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');


        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify-code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');

        // show all course
        Route::get('course', 'CourseController@show_all')->name('course.all');
        Route::post('course/create', 'CourseController@create')->name('course.create');
        Route::post('course/update/{id}', 'CourseController@update')->name('course.update');

        // users section
        Route::get('users', 'ManageUserController@show_all')->name('user.all');
        Route::post('course/update/{id}', 'ManageUserController@update')->name('course.update');

    });

});

