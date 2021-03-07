<?php

use App\Http\Middleware\AdminCheck;
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

Route::prefix('app')->middleware([AdminCheck::class])->group(function() {
    Route::post('/create_tag', 'AdminController@addTag');
    Route::get('/get_tags', 'AdminController@getTag');
    Route::post('/edit_tag', 'AdminController@editTag');
    Route::post('/delete_tag', 'AdminController@deleteTag');

    Route::post('/create_category', 'AdminController@addCategory');
    Route::post('/upload', 'AdminController@upload');
    Route::get('/get_category', 'AdminController@getCategory');
    Route::post('/edit_category', 'AdminController@editCategory');
    Route::post('/delete_category', 'AdminController@deleteCategory');
    Route::post('/create_user', 'AdminController@addUser');
    Route::get('/get_users', 'AdminController@getUser');
    Route::post('/edit_user', 'AdminController@editUser');

    Route::post('/delete_image', 'AdminController@deleteImage');

    Route::post('/admin_login', 'AdminController@adminLogin');

    //Role routes
    Route::post("/create_role","AdminController@addRole");
    Route::get("/get_roles","AdminController@getRoles");
    Route::post("/edit_role","AdminController@editRole");

});



Route::get('/logout', 'AdminController@logout');

Route::get('/', 'AdminController@index');
Route::get('{slug}', 'AdminController@index');



/*
Route::get('/', function () {
    return view('welcome');
});
Route::get('{slug}', function () {
    return view('welcome');
});
*/
Route::get('/home', 'HomeController@index')->name('home');
