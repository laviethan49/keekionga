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

Route::get('/', function()
{
    return view('index');
});
Route::get('/index', function()
{
    return view('index');
});
Route::get('/contact', function()
{
	return view('contact');
});
Route::get('/philosophy', function()
{
	return view('philosophy');
});
Route::get('/news', function()
{
	return view('news');
});
Route::get('/offers', function()
{
	return view('offers');
});
Route::get('/location', function()
{
	return view('location');
});

// Route::get('php_info', function(){
// 	phpInfo();
// });