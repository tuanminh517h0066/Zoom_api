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
/*
if (env('APP_ENV') === 'Production') {
    \URL::forceScheme('https');
}
*/

Route::get('/login', 'AuthController@getLogin')->name('login.form');
Route::post('/login', 'AuthController@postLogin')->name('login.post');
Route::get('/logout', 'AuthController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}/{email}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//API 
Route::get('api/members', 'Backend\API\MemberApiController@form')->name('member.form_api');
Route::post('api/addNewUser', 'Backend\API\MemberApiController@store')->name('member.api.save');

Route::get('test/cron-ranking-weekly', function() {
    Artisan::call('cron:ranking_weekly');
    echo 'Succuess';
});

// Home Frontend Route
    Route::get('/', 'Frontend\HomeController@index');
    Route::get('/home', 'Frontend\HomeController@index')->name('frontend.home');

    Route::get('/create', 'Zoom\MeetingController@getcreate')->name('get.create');
    // Route::post('/check-post', 'Zoom\MeetingController@postCreate')->name('post.create');
    Route::post('/postcreate','Zoom\MeetingController@store')->name('post.create.zoom');

    Route::get('/meeting/{id}','Zoom\MeetingController@joinMeeting')->name('join.meeting');


Route::middleware('auth:members')->namespace('Frontend')->group(function () {
    
});

Route::namespace('Backend')->prefix('backend')->group(function () {
    Route::get('/login', 'AuthController@getLogin')->name('backend.login.form');
    Route::post('/login', 'AuthController@postLogin')->name('backend.login.post');
    Route::get('/logout', 'AuthController@logout')->name('backend.logout');
});

// Route BackEnd
Route::middleware('auth:web')->namespace('Backend')->prefix('backend')->group(function () {
    Route::get('/', 'DashboardController@index')->name('backend.dashboard');

    // Member Route
    Route::get('/members', 'MembersController@index')->name('member.index');
    Route::get('/members/new', 'MembersController@form')->name('member.new');
    Route::get('/members/{member}', 'MembersController@form')->name('member.form');
    Route::post('/members/save', 'MembersController@post')->name('member.save');
    Route::post('/members/{member}/delete', 'MembersController@delete')->name('member.delete');
    Route::post('/members/{member}/restore', 'MembersController@restore')->name('member.restore');
    Route::post('/members/{member}/force-delete', 'MembersController@forceDelete')->name('member.force-delete');
    Route::post('/members/change-status', 'MembersController@ajaxChangeStatus')->name('member.change-status');
    Route::post('/members/import-csv', 'MembersController@importCSV')->name('member.importcsv');
    //Route::get('/members/download-csv', 'MembersController@downloadCsv')->name('member.downloadcsv');
    Route::get('download-csv', 'MembersController@downloadCsv')->name('member.downloadcsv');
   

    Route::get('/profile', 'AuthController@getProfile')->name('backend.profile');
    Route::post('/profile/save', 'AuthController@postProfile')->name('backend.profile.post');
  //ROUTES
});
// DO NOT EDIT THIS LINE