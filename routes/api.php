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
});