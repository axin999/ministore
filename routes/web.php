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

/*Route::get('/', function () {
    return view('additems');
});*/
Route::get('/view_items', function(){

	$items = App\Item::all();
	return $items;
});

Route::post('/items', 'ItemsController@index');
Route::get('/showitemlist', 'ItemsController@showitemlist');
Route::get('/showpricesetprice', 'PricesetsController@priceset_price');
Route::put('/updateitemlist/{id}', 'ItemsController@updateitemlist');
Route::get('/getcategory', 'CategoriesController@getcategory');
Route::resource('taemomalaki','CategoriesController');
Route::get('/addcategories', 'CategoriesController@index');
Route::post('/additem','ItemsController@additems');
Route::post('/addcategories', 'CategoriesController@addcategories');
Route::post('/addpricesets', 'PricesetsController@addpriceset');
Route::post('/edit',[
	'uses'=> 'CategoriesController@editCategory',
	'as' => 'edit'
]);
Route::post('/delete/{id}','CategoriesController@destroy');
Route::post('/deletepriceset/{id}','PricesetsController@destroy');
Route::get('/showpricesets',[
	'uses'=>'PricesetsController@showpricesets',
	'as'=>'showpricesets'
]);
Route::get('/addpricesets',[
	'uses'=>'PricesetsController@addpricesets',
	'as'=>'addpricesets'
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/users', 'UsersController@index');
//Route::get('{path}', 'HomeController@index')->where('path','.*');
//Route::get('{path}',"HomeController@index")->where( 'path', '([A-z\d-\/_.]+)?' );
Route::get('{path}', 'HomeController@index')->where( 'path' , '([A-z\d\-\/_.]+)?' );


