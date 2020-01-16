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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

//Password reset route
Route::group([
  'middleware' => 'api',
  'prefix' => 'password'
], function () {
  Route::post('/create', 'API\PasswordResetController@create');
  Route::get('find/{token}/{email}', 'API\PasswordResetController@find')->name('user.reset');
  Route::post('reset', 'API\PasswordResetController@reset')->name('user.passwordreset');
});

Route::group(['middleware' => 'auth:api'], function () {
  Route::post('review', 'API\BookController@review');
  Route::post('review/delete/{id}', 'API\BookController@reviewDelete');
  Route::get('logout', 'API\UserController@logout');
  Route::get('myaccount', 'API\AccountController@myaccount');
  Route::get('myaccount/changepic', 'API\AccountController@changepic');
  Route::post('wishlist', 'API\BookController@wishlistAdd');

  //order route
  Route::get('orders', 'API\BookController@orders');
});


//Book route
Route::group([
  'prefix' => 'book'
], function () {
  Route::get('book_order', 'API\BookController@book_order');

  Route::get('search', 'API\BookController@search');

  Route::get('singlebook/{id}', 'API\BookController@book');
  
  Route::get('most_discounted', 'API\BookController@most_discounted');

  Route::get('reviews/{id}', 'API\BookController@reviews');
});

Route::get('authors', 'API\BookController@authors');
Route::get('authors/all', 'API\BookController@authors_all');
Route::get('authors/top', 'API\BookController@authors_top');
Route::get('author/books/{id}/', 'API\BookController@authorBooks');
Route::get('author/{id}', 'API\BookController@author');
Route::get('filter/author/', 'API\BookController@author_filter');
Route::get('filter/publisher/', 'API\BookController@publisher_filter');
// Route::get('filter/category/', 'API\BookController@category_filter');

Route::get('categories', 'API\BookController@categories');
Route::get('category/all', 'API\BookController@categories_all');
Route::get('category/{id}', 'API\BookController@Category');
Route::get('categories/search', 'API\BookController@category_search')->name('api.cat_search');
Route::get('publishers/search', 'API\BookController@publisher_search')->name('api.pub_search');
Route::get('authors/search', 'API\BookController@author_search')->name('api.auth_search');

Route::get('publishers', 'API\BookController@publishers');
Route::get('publisher/all', 'API\BookController@publisher_all');
Route::get('publisher/books/{id}/', 'API\BookController@publisherBooks');
Route::get('publisher/{id}', 'API\BookController@Publisher');\

Route::post('subscribe', 'API\SubscriptionController@store');

Route::post('order', 'API\BookController@orderAdd');

