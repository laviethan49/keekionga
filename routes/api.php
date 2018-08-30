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
	// Posts
		- Add in functionality to get all posts from a certain month.
		- Add functionality for changing a post to be 'special' or not which would always have it at the top.
	// Products
		- Add in functionality to e-mail price list with user's changes with user's e-mail address, name, number, and a comment from the user.
		- Add functionality for changing if a certain product is hidden or not.
	// Philosophy
		- Add in what we're about page that reads off of file to populate page. Currently have it, but not reading from a 		file.
	// General
		- Add functionality to change pictures around if Clayton wants a new picture.
*/