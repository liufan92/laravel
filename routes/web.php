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



Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
	    return view('welcome');
	});

	Route::get('/home', 'HomeController@index');

	Route::get('/profile/{username}', [
		'uses' => 'ProfileController@profile',
		'as' => 'profile'
	]);

	Route::get('/profile/{username}/edit', [
		'uses' => 'ProfileController@profileEdit',
		'as' => 'profile.edit'
	]);

	Route::post('/profile/{username}/update', [
		'uses' => 'ProfileController@profileUpdate',
		'as' => 'profile.update'
	]);

	Route::get('/userimage/{filename}', [
		'uses' => 'ProfileController@getUserImage',
		'as' => 'profile.image'
	]);

	Route::post('/comments', [
		'uses' => 'CommentController@store',
		'as' => 'comment.post'
	]);

	Route::post('/like', [
		'uses' => 'ArticlesController@postLikeArticle',
		'as' => 'like'
	]);

	Route::resource('articles', 'ArticlesController');
});


