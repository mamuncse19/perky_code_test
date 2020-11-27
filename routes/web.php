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

Route::get('/', 'HomeController@index');

/*
  |--------------------------------------------------------------------------
  | Category Routes
  |--------------------------------------------------------------------------
 */
Route::prefix('category')->group(function() {
    Route::get('/list', 'Product\CategoryController@index')->name('categoryList');
    Route::get('/create', 'Product\CategoryController@create')->name('categoryCreate');
    Route::post('/store', 'Product\CategoryController@store')->name('categoryStore');
    Route::get('/edit/{id}', 'Product\CategoryController@edit')->name('categoryEdit');
    Route::post('/update/{id}', 'Product\CategoryController@update')->name('categoryUpdate');
    Route::get('/delete/{id}', 'Product\CategoryController@destroy')->name('categoryDelete');
});

/*
  |--------------------------------------------------------------------------
  | Products Routes
  |--------------------------------------------------------------------------
 */

  Route::prefix('product')->group(function() {
    Route::get('/list', 'Product\ProductController@index')->name('productList');
    Route::get('/create', 'Product\ProductController@create')->name('productCreate');
    Route::post('/store', 'Product\ProductController@store')->name('productStore');
    Route::get('/edit/{id}', 'Product\ProductController@edit')->name('productEdit');
    Route::post('/update/{id}', 'Product\ProductController@update')->name('productUpdate');
    Route::get('/delete/{id}', 'Product\ProductController@destroy')->name('productDelete');
});
  Route::group(['prefix' => 'purchase'],function(){
    Route::get('/','Product\PurchaseController@index')->name('purchaseCreate');
    Route::post('/getSearchProduct','Product\PurchaseController@getSearchProduct');
    Route::post('/getSelectedProduct','Product\PurchaseController@getSelectedProduct');
  });
