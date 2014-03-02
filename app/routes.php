<?php

Route::get('/', function()
{
    return View::make('hello');
});

Route::controller('admin/categories', 'CategoriesController');
Route::controller('admin/products', 'ProductsController');
