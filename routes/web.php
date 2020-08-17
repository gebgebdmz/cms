<?php

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


// ss

use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;
use App\EmailQueue;


/**=============================Login & Register================================================== **/
Auth::routes();
// /**=============================Email Verification================================================== **/
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('/verify/{token}', 'VerifyController@VerifyEmail')->name('verify');
// Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');

// /**=============================Reset Password================================================== **/
Route::post('reset-password-without-token', 'ResetPasswordController@validatePasswordRequest');
Route::post('reset-password-with-token', 'ResetPasswordController@resetPassword');


Route::get('/', 'HomeController@display')->name('home');
Route::get('/store', 'StoreController@display');

// /**=============================dashboard================================================== **/
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'AdminController@index');
});

// /**=============================Activity-Log================================================== **/


// Route::group(['middleware' => ['auth','CheckRole:1']], function () {
Route::get('/activitylog', 'ActivitylogController@index')->name('activitylog');
Route::get('/activitylog/get-activity', 'ActivitylogController@getDataActivity')->name('activity.getData');
// });

// /**=============================Roles================================================== **/
// Route::group(['middleware' => ['auth','CheckRole:1']], function () {
//     Route::resource('role', 'RolesController');
// });
// 

/**=============================Users================================================== **/
Route::get('/user', 'UserController@index')->name('user');
Route::get('/user/get-data', 'UserController@getDataUser')->name('user.getData');
Route::post('/user/insert-user', 'UserController@insertUser');
Route::post('/user/edit-user/{user}', 'UserController@updateUser')->name('editUser');
Route::get('/user/delete-user/{user}', 'UserController@deleteUser')->name('deleteUser');

// /**=============================Application================================================== **/
// Route::group(['middleware' => ['auth','CheckRole:1']], function () {
    Route::get('/app', 'appController@index');
    Route::post('/app/create', 'appController@create');
    Route::get('/destroy/{app}', 'appController@destroy');
    Route::post('/update/{app_id}', 'appController@update');
    Route::get('/ajaxdata/get-app','appController@getapp')->name('ajaxdata.app');
    // });

/**=============================EmailQueue================================================== **/
// Route::group(['middleware' => ['auth','CheckRole:1']], function () {
    Route::get('/email', 'EmailQueueController@index');
    Route::get('/ajaxdata/get-email','EmailQueueController@getEmail')->name('ajaxdata.email');
    // });
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/studymaterial', 'StudyMaterialController@index');


Route::get('/dashboard', 'AdminController@index');
/**=============================Profile================================================== **/
Route::get('/myprofile', 'ProfileController@display');
Route::get('/myprofile/edit_email', 'ProfileController@edit_email');
Route::get('/myprofile/edit_password', 'ProfileController@edit_password');
Route::post('/myprofile', 'ProfileController@update');
Route::post('/myprofile/update_email', 'ProfileController@update_email');
Route::post('/myprofile/update_password', 'ProfileController@update_password');
Route::get('/verify_update_email/{token}', 'ProfileController@verify_update_email');


// Route::post('/posts/search/role',['as'=>'search-role','uses'=>'RolesController@search']);
// // Route::post('/posts/search/role', ['as' => 'search-role', 'uses' => 'RolesController@search']);
// Route::get('/search','SearchController@search');


/**=============================RoleApp================================================== **/
Route::get('/roleapp', 'RoleAppController@display');
Route::post('/roleapp/create', 'RoleAppController@create');
Route::get('/roleapp/delete/{roleapp}', 'RoleAppController@delete');
Route::post('/roleapp/update/{id}', 'RoleAppController@update');
Route::get('ajaxdata/getapp', 'RoleAppController@getroleapp')->name('ajaxdata.getroleapp');
Route::get('/roleapp/search', 'RoleAppController@search');



// //BasConfig

Route::get('/BasConfig/Insert', 'BasConfigController@create');

Route::get('/BasConfig', 'BasConfigController@index');
Route::get('/BasConfig/{BasConfig}', 'BasConfigController@show');
Route::get('/BasConfig/Update/{BasConfig}', 'BasConfigController@edit');

Route::get('ajaxdata/getdata', 'BasConfigController@getdata')->name('ajaxdata.getdata');
Route::patch('/BasConfig/Update/{BasConfig}', 'BasConfigController@update');
Route::post('/BasConfig/Insert', 'BasConfigController@store');

// BasRole

Route::get('/BasRole/Insert', 'BasRoleController@create');
Route::get('/BasRole', 'BasRoleController@index');
Route::get('/BasRole/{BasRole}', 'BasRoleController@show');
Route::get('/BasRole/Update/{BasRole}', 'BasRoleController@edit');
Route::get('ajaxdata/getrole', 'BasRoleController@getrole')->name('ajaxdata.getrole');
Route::patch('/BasRole/Update/{BasRole}', 'BasRoleController@update');
Route::post('/BasRole/Insert', 'BasRoleController@store');
Route::get('/BasRole/Delete/{BasRole}', 'BasRoleController@destroy');


// Bas Cron 
Route::get('/BasCron','BasCronController@index');
Route::get('ajaxdata/getcron','BasCronController@getcron')->name('ajaxdata.getcron');


// //cron email queue
// Route::get('/send-mail', 'EmailQueueController@send');
Route::get('/emailqueue', 'EmailQueueController@sendSMTP');

//logout+destroy session
Route::get('/logout', 'Auth\LoginController@logout');


// menu====================================
Route::group(['middleware' => ['auth']], function () {

    Route::get('/menu', 'MenuController@index')->name('menu');
    Route::post('/menu/create', 'MenuController@create')->name('create');
    Route::get('/menu/destroy/{id}', 'MenuController@destroy');
    Route::post('/menu/update/{id}', 'MenuController@update');
    Route::get('/ajaxdata/getdata', 'MenuController@getData')->name('ajaxdata.datajax');
});

Route::group(['prefix' => 'cms-course-user'], function () {
    Route::get('/', 'CmsCourseUserController@index')->name('cms-course-user');
    Route::get('/ajaxdata/getcourseuser', 'CmsCourseController@getcourseUser')->name('ajaxdata.getcourseuser');
});
