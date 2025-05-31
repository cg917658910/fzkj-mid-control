<?php


use think\Route;

Route::group('login', function () {
    Route::post('login', 'Login/login');
    Route::post('check_google_code', 'Login/check_google_code');
});

Route::group(':controller', function () {
    Route::get('page', ':controller/page');
    Route::get('list', ':controller/list');
    Route::get('find/:id', ':controller/find');
});
Route::group(':controller', function () {
    Route::post('create', ':controller/create');
    Route::post('update', ':controller/update');
    Route::post('change_status', ':controller/changeStatus');
    Route::get('delete/:id', ':controller/delete');
});
