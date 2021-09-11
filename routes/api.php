<?php

use Illuminate\Http\Request;

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

// Redprint Auth Route
// You can implement your own Auth endpoint and method
Route::post(
    'permissible/auth/token',
    '\Shahnewaz\Permissible\Http\Controllers\API\AuthController@postAuthenticate'
)->name('permissible.auth.token');

// API Routes
// Access them like: /api/v1/route
Route::any('token', 'Backend\API\TokenApiController@saveToken')->name('api.token');
Route::any('notify', 'Backend\API\TokenApiController@index')->name('api.notify');
Route::middleware(['jwt.auth', 'role:admin'])->namespace('Backend\API')->prefix('v1/backend')->group(function () {
    //ROUTES

    /*// Member1 Route
    Route::get('member1s', 'Member1sController@index')->name('api.member1.index');
    Route::get('/member1s/{member1}', 'Member1sController@form')->name('api.member1.form');
    Route::post('/member1s/save', 'Member1sController@post')->name('api.member1.save');
    Route::post('/member1s/{member1}/delete', 'Member1sController@delete')->name('api.member1.delete');
*/

    // Test Route
    Route::get('tests', 'TestsController@index')->name('api.test.index');
    Route::get('/tests/{test}', 'TestsController@form')->name('api.test.form');
    Route::post('/tests/save', 'TestsController@post')->name('api.test.save');
    Route::post('/tests/{test}/delete', 'TestsController@delete')->name('api.test.delete');
    Route::post('/tests/{test}/restore', 'TestsController@restore')->name('api.test.restore');
    Route::post('/tests/{test}/force-delete', 'TestsController@forceDelete')->name('api.test.force-delete');

});



//API 
//Route::get('test', 'Frontend\API\AuthController@test');
//Route::get('register', 'Frontend\API\AuthController@register');
Route::post('login', 'Frontend\API\AuthController@login');
//Route::post('logout', 'Frontend\API\AuthController@logout');

/*Route::middleware('jwt.auth')->get('users', function () {
    echo 111;die;
    //return auth('api')->user();
});*/