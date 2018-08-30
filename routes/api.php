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

Route::prefix('posts')->group(function(){
	Route::post('/new', 'PostController@createPost');
	Route::get('/ten', 'PostController@getTenPosts');
	Route::get('/more/{lastID}', 'PostController@tenMorePosts');
	Route::get('/months', 'PostController@getMonthOptions');
	Route::get('/monthly_posts/{month_num}', 'PostController@getPostsForMonth');
	Route::post('/edit/{postID}', 'PostController@editPost');
	Route::post('/delete/{postID}', 'PostController@deletePost');
	Route::post('/special/{postID}', 'PostController@special');
	Route::post('/unspecial/{postID}', 'PostController@unspecial');
	Route::post('/hide/{postID}', 'PostController@hidePost');
	Route::post('/show/{postID}', 'PostController@showPost');
});

Route::prefix('products')->group(function(){
	Route::post('/new', 'ProductController@createProduct');
	Route::get('/all', 'ProductController@getProducts');
	Route::get('/groups', 'ProductController@getGroupsList');
	Route::post('/edit/{productID}', 'ProductController@editProduct');
	Route::post('/delete/{productID}', 'ProductController@deleteProduct');
	Route::post('/email', 'ProductController@sendEmailForInquiry');
	Route::post('/hide/{productID}', 'ProductController@hideProduct');
	Route::post('/show/{productID}', 'ProductController@showProduct');
});

/*
	Still left To Do On Website:
	// Location
		- Add areas for where our products are sold on embedded map.
	// Posts
		- Add to month selection to see year as well.
	// Philosophy
		- Add in what we're about page that reads off of file to populate page. Currently have it, but not reading from a 		file.
	// General
		- Add functionality to change pictures around if Clayton wants a new picture.
		- Mobile compatibility.
*/