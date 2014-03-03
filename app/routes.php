<?php

Route::get('/', array(
    'uses' => 'StoreController@getIndex',
));

Route::controller('admin/categories', 'CategoriesController');
Route::controller('admin/products', 'ProductsController');
Route::controller('store', 'StoreController');
Route::controller('users', 'UsersController');
