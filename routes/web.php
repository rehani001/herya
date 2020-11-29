<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
});

Route::get('/catalogue','App\Http\Controllers\FrontendController@index');

//Admin Login
Route::get('/wp-admin','App\Http\Controllers\AdminController@login');
Route::post('/postlogin','App\Http\Controllers\AdminController@postlogin');

Route::group(['middleware' => ['auth','checkRole:admin']], function() {
	Route::get('/dashboard','App\Http\Controllers\AdminController@dashboard');
	Route::post('/postkatalog','App\Http\Controllers\CatalogueController@store');
	Route::get('/catalogue-list/add','App\Http\Controllers\CatalogueController@create');
	Route::get('/catalogue-list','App\Http\Controllers\CatalogueController@index');
	Route::get('/catalogue-list/edit/{id}','App\Http\Controllers\CatalogueController@edit');
	Route::post('/catalogue-list/update/{id}','App\Http\Controllers\CatalogueController@update');
	Route::get('/catalogue-list/delete/{id}','App\Http\Controllers\CatalogueController@destroy');
	Route::get('/logout', 'AdminController@logout');
});


Route::get('login', function() {
    if (Auth::check()){
        return redirect('/dashboard');
    }
    else{
        return view('admin.login');
    }
})->name('login');

Route::get('/catalogue/detail/{id}','App\Http\Controllers\CatalogueController@show');

Route::get('/contact', function(){
	return view('contact');
});

Route::get('/cart', function(){
	return view('cart');
});

Route::get('/about', function(){
	return view('about');
});
