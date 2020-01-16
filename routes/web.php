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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/emailConfirmed', function () {
    return view('frontend.partials.emailConfirmed');
});

Route::get('/tokenUnmatched', function () {
    return view('frontend.partials.tokenUnmatched');
});

Route::get('/', function () {
    return view('frontend.pages.index');
});

// Admin Routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'backend\PagesController@index')->name('admin.index');
    Route::post('/', 'backend\PagesController@orderFiltered')->name('admin.orderFiltered');
    Route::post('exportOrdersPDF', 'backend\PagesController@exportOrdersPDF')->name('admin.exportOrdersPDF');

    //Category order 
    Route::get('/cat_order', 'backend\CategoryOrderController@index')->name('admin.cat_order.index');
    Route::get('/cat_order/edit/{id}', 'backend\CategoryOrderController@edit')->name('admin.cat_order.edit');
    Route::post('/cat_order/edit/{id}', 'backend\CategoryOrderController@update')->name('admin.cat_order.update');
    Route::post('/cat_order/delete/{id}', 'backend\CategoryOrderController@delete')->name('admin.cat_order.delete');
    Route::post('/create', 'backend\CategoryOrderController@create')->name('admin.cat_order.create');

    //Order route
    Route::post('/order/delivered/{id}', 'backend\OrderController@deliverd')->name('admin.order.delivered');
    Route::post('/order/seen/{id}', 'backend\OrderController@seen')->name('admin.order.seen');
    Route::post('/order/delete/{id}', 'backend\OrderController@delete')->name('admin.order.delete');

    //Publishers routes
    Route::group(['prefix' => '/publisher'], function () {
        Route::get('/create', 'backend\publisherController@create')->name('admin.publisher.create');
        Route::post('/store', 'backend\publisherController@store')->name('admin.publisher.store');
        Route::post('/delete/{id}', 'backend\publisherController@delete')->name('admin.publisher.delete');
        Route::get('/edit/{id}', 'backend\publisherController@edit')->name('admin.publisher.edit');
        Route::post('/edit/{id}', 'backend\publisherController@update')->name('admin.publisher.update');
        Route::get('/search', 'backend\publisherController@search')->name('admin.publisher.search');
    });

    //Category routes
    Route::group(['prefix' => '/category'], function () {
        Route::get('/createcategory', 'backend\AdmincategoryController@create')->name('admin.category.create');
        Route::post('/addcategory', 'backend\AdmincategoryController@addcategory')->name('admin.category.addcategory');
        Route::post('/delete/{id}', 'backend\AdmincategoryController@delete')->name('admin.category.delete');
        Route::get('/edit/{id}', 'backend\AdmincategoryController@edit')->name('admin.category.edit');
        Route::post('/edit/{id}', 'backend\AdmincategoryController@update')->name('admin.category.update');
        Route::get('/search', 'backend\AdmincategoryController@search')->name('admin.category.search');
    });

    //Authors routes
    Route::group(['prefix' => '/author'], function () {
        Route::get('/create', 'backend\AdminauthorController@create')->name('admin.author.create');
        Route::post('/store', 'backend\AdminauthorController@store')->name('admin.author.store');
        Route::post('/delete/{id}', 'backend\AdminauthorController@delete')->name('admin.author.delete');
        Route::get('/edit/{id}', 'backend\AdminauthorController@edit')->name('admin.author.edit');
        Route::post('/edit/{id}', 'backend\AdminauthorController@update')->name('admin.author.update');
        Route::post('/set_top/{id}', 'backend\AdminauthorController@set_top')->name('admin.author.set_top');
        Route::get('/search', 'backend\AdminauthorController@search')->name('admin.author.search');
    });

    //Books route
    Route::group(['prefix' => '/book'], function () {
        Route::get('/createbook', 'backend\AdminbookController@create')->name('admin.book.create');
        Route::post('/addbook', 'backend\AdminbookController@addbook')->name('admin.book.addbook');
        Route::get('/allbooks', 'backend\AdminbookController@index')->name('admin.book.index');
        Route::post('/delete/{id}', 'backend\AdminbookController@delete')->name('admin.book.delete');
        Route::post('/destroyImage/{id}', 'backend\AdminbookController@destroyImage')->name('admin.book.destroyImage');
        Route::get('/edit/{id}', 'backend\AdminbookController@edit')->name('admin.book.edit');
        Route::post('/edit/{id}', 'backend\AdminbookController@update')->name('admin.book.update');
        Route::get('/search', 'backend\AdminbookController@search')->name('admin.book.search');
    });

    //Users route
    Route::group(['prefix' => '/users'], function () {
    Route::get('/createuser', 'backend\AdminUserController@create')->name('admin.user.create');
    Route::post('/adduser', 'backend\AdminUserController@addUser')->name('admin.user.addUser');
    Route::get('/alladmins', 'backend\AdminUserController@index')->name('admin.user.index');
    Route::post('/delete/{id}', 'backend\AdminUserController@delete')->name('admin.user.delete');
    Route::get('/edit/{id}', 'backend\AdminUserController@edit')->name('admin.user.edit');
    Route::post('/edit/{id}', 'backend\AdminUserController@update')->name('admin.user.update');
    });

     //Discount route
     Route::group(['prefix' => '/discounts'], function () {
        // Route::get('/create', 'backend\DiscountController@create')->name('admin.discount.create');
        Route::post('/add', 'backend\DiscountController@store')->name('admin.discount.store');
        Route::get('/index', 'backend\DiscountController@index')->name('admin.discount.index');
        // Route::post('/delete/{id}', 'backend\DiscountController@destroy')->name('admin.discount.destroy');
        // Route::get('/edit/{id}', 'backend\DiscountController@edit')->name('admin.discount.edit');
        // Route::post('/edit/{id}', 'backend\DiscountController@update')->name('admin.discount.update');
        });

    // Admin Login Routes
    Route::get('/login', 'Auth\Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Auth\Admin\LoginController@login')->name('admin.login.submit');
    Route::post('/logout/submit', 'Auth\Admin\LoginController@logout')->name('admin.logout');

    //Forgot password email sent
    Route::get('/password/reset', 'Auth\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/resetPost', 'Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');

    //password reset
    Route::get('/password/reset/{token}', 'Auth\Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset', 'Auth\Admin\ResetPasswordController@reset')->name('admin.password.reset.post');

    //subscription route
    Route::group(['prefix' => '/subscriptions'], function () {
        Route::get('/index', 'backend\SubscriptionController@index')->name('admin.subscription.index');
    });



});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');

    return "Cleared!";
});
