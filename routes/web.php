<?php

Route::get('/', 'WelcomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/Producer', 'ProducerController@index')->name('producer');

Route::get('/Category', 'CategoryController@index')->name('category');

Route::get('/City', 'CityController@index')->name('city');
Route::get('/City/GetAllAsJson', 'CityController@getAllAsJson');

Route::get('/Product', 'ProductController@index')->name('product_index');
Route::get('/Product/Details/{product_id}', 'ProductController@details')->name('product_details');

Route::get('/Role', 'RoleController@index')->name('role_index');
Route::get('/Role/Details/{role_id}', 'RoleController@details')->name('role_details');

Route::get('/Cart', 'CartController@index')->name('cart');
Route::post('/Cart/Add', 'CartController@add')->name('cart_add');
Route::post('/Cart/Update/Quantity', 'CartController@updateQuantity')->name('cart_update_quantity');
Route::post('/Cart/Product/Remove', 'CartController@productRemove')->name('cart_product_emove');
Route::get('/Bill/Generate', 'BillController@generate')->name('bill_generate');
Route::post('/CitySelected', 'Controller@citySelected');

// Admin routes

Route::middleware(['admin'])->group(function(){

    //Account
    Route::post('/Account/Block',  'UserController@block')->name('account_block');
    Route::post('/Account/Unblock',  'UserController@unblock')->name('account_unblock');

    // User
    Route::post('/User/MakeAdmin',  'UserController@makeAdmin')->name('user_make_admin');
    Route::post('/User/RemoveAdmin',  'UserController@removeAdmin')->name('user_remove_admin');
    Route::get('/User/All',  'UserController@index')->name('users');

    //Producer
    Route::match(['get', 'post'], '/Producer/Create',  'ProducerController@create')->name('producer_create');
    Route::post('/Producer/Update',  'ProducerController@update')->name('producer_update');

    //Category
    Route::match(['get', 'post'], '/Category/Create',  'CategoryController@create')->name('category_create');
    Route::post('/Category/Update', 'CategoryController@update')->name('category_update');

    //City
    Route::match(['get', 'post'], '/City/Create',  'CityController@create')->name('city_create');
    Route::post('/City/Update',  'CityController@update')->name('city_update');

    //Product
    Route::match(['get', 'post'], '/Product/Create',  'ProductController@create')->name('product_create');
    Route::match(['get', 'post'], '/Product/Update/{product_id}',  'ProductController@update')->name('product_update');
    Route::match(['get', 'post'], '/Product/{product_id}/Stock/Update/',  'ProductController@updateStock')->name('product_update_stock');

    //Role
    Route::match(['get', 'post'], '/Role/Create',  'RoleController@create')->name('role_create');
    Route::match(['get', 'post'], '/Role/Update/{role_id}',  'RoleController@update')->name('role_update');

    //Order
    Route::get('/Order/LastWeek', 'OrderController@getAllOrdersOfLastWeek')->name('order_last_week');

});

Route::middleware(['customer'])->group(function(){
    
    Route::post('/Order/Place', 'OrderController@order')->name('place_order');

});

Route::middleware(['auth'])->group(function(){

    Route::get('/User',  'UserController@details')->name('user_details');
    Route::post('/User/Update',  'UserController@update')->name('user_update');
    Route::post('/User/Delete',  'UserController@delete')->name('user_delete');

    Route::get('/Order', 'OrderController@index')->name('order_index');
    Route::get('/Order/Category/{category_id}', 'OrderController@getAllByCategory')->name('order_by_category');
    Route::get('/Order/Producer/{category_id}', 'OrderController@getAllByProducer')->name('order_by_producer');
});


