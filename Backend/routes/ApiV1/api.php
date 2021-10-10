<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/ping', function() {
    Redis::set('ping', 'pong');
});
    

Route::prefix('v1')->group(function () {
    
 
    //auth
    Route::post('register', 'Auth\AuthController@register');
    Route::get('email/verification/{userId}', 'Auth\AuthController@verifyUser');

    Route::post('login', 'Auth\AuthController@login');
    Route::post('reset-password-request', 'Auth\ForgotPasswordController@resetPasswordRequest');
    Route::post('update-password', 'Auth\ResetPasswordController@updatePassword');
    
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('/userProfile', function (Request $request) {
            return $request->user();
        });
        Route::post('email/verification/resend', 'Auth\AuthController@resendVerificationEmail')->name('verify.user');
        Route::post('updateProfile', 'UserController@update');
        Route::post('logout', 'Auth\AuthController@logout');
        Route::get('search', 'SearchController@search');

    });

    // all users
    Route::get('user', 'UserController@index');
    
   Route::group(['middleware' => 'auth:sanctum'], function() {
        //Route::get('task/mytasks', 'TaskController@myTasks');
        //Route::get('task/find/{slug}', 'TaskController@getTaskBySlug');
        Route::resource('task', TaskController::class);
    });
   
   Route::group(['middleware' => 'auth:sanctum'], function() {
       //Route::get('category/mycategories', 'CategoryController@myCategories');
       Route::resource('category', CategoryController::class);
   });

   Route::group(['middleware' => 'auth:sanctum'], function() {
       Route::get('comment/task/{taskId}', 'CommentController@getCommentsForTask');
       Route::resource('comment', CommentController::class);
   });
    
});
    
