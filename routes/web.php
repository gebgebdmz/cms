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
// Auth::routes();
// /**=============================Email Verification================================================== **/
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
// Route::get('/verify/{token}', 'VerifyController@VerifyEmail')->name('verify');
// // Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');

// /**=============================Reset Password================================================== **/
// Route::post('reset-password-without-token', 'ResetPasswordController@validatePasswordRequest');
// Route::post('reset-password-with-token', 'ResetPasswordController@resetPassword');


// Route::get('/', 'HomeController@display')->name('home');


// /**=============================dashboard================================================== **/
// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/dashboard', 'AdminController@index');

// });

// /**=============================Activity-Log================================================== **/


// Route::group(['middleware' => ['auth','CheckRole:1']], function () {
//     Route::get('/activitylog', 'ActivitylogController@index')->name('activitylog');
//     Route::post('/activitylog/search', ['as' => 'search-log', 'uses' => 'ActivitylogController@search']);
//     Route::get('/activitylog/get-activity', 'ActivitylogController@getDataActivity')->name('activity.getData');
// });

// /**=============================Roles================================================== **/
// Route::group(['middleware' => ['auth','CheckRole:1']], function () {
//     Route::resource('role', 'RolesController');
// });
// /**=============================Users================================================== **/
// Route::group(['middleware' => ['auth','CheckRole:1']], function () {
//     Route::get('/user', 'UserController@index')->name('user');
//     Route::post('/user/editUser/{user}', 'UserController@updateUser')->name('editUser');
//     Route::get('/user/deleteUser/{user}', 'UserController@deleteUser')->name('deleteUser');
//     Route::post('/user/create', 'UserController@create');
//     Route::get('/user/verify/{email}/{code}', 'UserController@verifyEmail')->name('userVerify');
//     Route::get('/user/get-data', 'UserController@getDataUser')->name('user.getData');

// });

// Route::group(['middleware' => ['auth','CheckRole:1']], function () {
//     Route::resource('user-role','UserRoleController');
//     Route::get('user-role/edit','UserRoleController@edit')->name('edit-user-role');
//     Route::get('user-role/delete','UserRoleController@delete')->name('delete-user-role');
//     Route::get('user-role/create', 'UserRoleController@create')->name('create-user-role');
//     Route::post('user-role/update', 'UserRoleController@update')->name('user-role.update');
//     Route::get('user-role/save', 'UserRoleController@destroy')->name('save');
// });

// // Route::group(['middleware' => ['auth','CheckRole:1']], function () {
// //     Route::resource('user-role','UserRoleController');
// //     Route::get('user-role/get','UserRoleController@get')->name('userloadjson');
// //     Route::get('user-role/edit','UserRoleController@edit')->name('edit-user-role');
// //     Route::get('user-role/delete','UserRoleController@delete')->name('delete-user-role');
// //     Route::get('user-role/create', 'UserRoleController@create')->name('create-user-role');
// //     Route::post('user-role/update', 'UserRoleController@update')->name('user-role.update');
// //     Route::get('user-role/save', 'UserRoleController@destroy')->name('save');

// /**=============================Application================================================== **/
// Route::group(['middleware' => ['auth','CheckRole:1']], function () {
//     Route::get('/app', 'appController@index');
//     Route::get('/app/show', 'appController@show');
//     Route::get('/app/create', 'appController@create');
//     Route::post('/posts/search/app', ['as' => 'search-posts', 'uses' => 'appController@searchApp']);
//     Route::post('/app/create', 'appController@create');
//     Route::get('/destroy/{app_id}', 'appController@destroy');
//     Route::post('/update/{app_id}', 'appController@update');
//     });


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', 'AdminController@index');
/**=============================Profile================================================== **/
Route::get('/myprofile', 'ProfileController@display');
Route::post('/myprofile', 'ProfileController@update');
// Route::post('update_email_without_token', 'ProfileController@validateEmailRequest');
// Route::post('update_email_with_token', 'ProfileController@updateEmail');
//test session
// Route::get('/testsession', 'ProfileController@testsession');

// Route::post('/posts/search/role',['as'=>'search-role','uses'=>'RolesController@search']);
// Route::get('/app', 'appController@index');
// Route::post('/app/create', 'appController@create');
// Route::get('/destroy/{app_id}', 'appController@destroy');
// Route::post('/update/{app_id}', 'appController@update');
// Route::get('ajaxdata/getapp','appController@getapp')->name('ajaxdata.getapp');
// // Route::post('/posts/search/role', ['as' => 'search-role', 'uses' => 'RolesController@search']);
// Route::get('/search','SearchController@search');


// /**=============================RoleApp================================================== **/
// Route::get('/roleapp', 'RoleAppController@display');
// Route::post('/roleapp/create', 'RoleAppController@create');
// Route::get('/roleapp/delete/{roleapp}', 'RoleAppController@delete');
// Route::post('/roleapp/update/{id}', 'RoleAppController@update');
// Route::get('ajaxdata/getapp','RoleAppController@getroleapp')->name('ajaxdata.getroleapp');
// Route::get('/roleapp/search','RoleAppController@search');



// //BasConfig
// Route::get('/basconfig','BasConfigsController@index')->name('ajaxdata');


// Route::get('/basconfig/insert','BasConfigsController@create');
// Route::post('/basconfig/insert','BasConfigsController@store');

// Route::get('/basconfig/update/{BasConfig}','BasConfigsController@edit');
// Route::patch('/basconfig/update/{BasConfig}','BasConfigsController@update');


// Route::get('ajaxdata/getdata','BasConfigsController@getdata')->name('ajaxdata.getdata');
// Route::get('/basconfig/{BasConfig}','BasConfigsController@show');

// //cron email queue
// Route::get('/send-mail', 'EmailQueueController@send');
// Route::get('/send-mail-smtp', 'EmailQueueController@sendSMTP');

// //logout+destroy session
// Route::get('/logout','LogoutController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/menu', 'MenuController@index')->name('menu');
