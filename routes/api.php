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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('posts')->group(function(){
	Route::post('/new', 'PostController@createPost');
	Route::get('/all', 'PostController@getAllPosts');
	Route::post('/edit/{postID}', 'PostController@editPost');
	Route::post('/delete/{postID}', 'PostController@deletePost');
});