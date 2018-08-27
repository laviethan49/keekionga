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
	Route::post('/edit/{postID}', 'PostController@editPost');
	Route::post('/delete/{postID}', 'PostController@deletePost');
});

Route::prefix('products')->group(function(){
	Route::post('/new', 'ProductController@createProduct');
	Route::get('/all', 'ProductController@getProducts');
	Route::get('/groups', 'ProductController@getGroupsList');
	Route::post('/edit/{productID}', 'ProductController@editProduct');
	Route::post('/delete/{productID}', 'ProductController@deleteProduct');
	Route::post('/email', 'ProductController@sendEmailForInquiry');
});

/*
	Still left To Do On Website:
		- Add in functionality to e-mail price list with user's changes with user's e-mail address, name, and number.
		- Add in functionality to get more posts without reloading the whole page, gets 10 at a time.
		- Add in functionality to get all posts from a certain month.
		- Add in what we're about page that reads off of file to populate page.
		- Add functionality to change pictures around if Clayton wants a new picture.
*/