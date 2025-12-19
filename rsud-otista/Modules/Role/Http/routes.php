<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'role', 'namespace' => 'Modules\Role\Http\Controllers'], function()
{
    Route::get('/', 'RoleController@index')->name('role');
    Route::get('/create', 'RoleController@create')->name('role.create');
    Route::post('/store', 'RoleController@store')->name('role.store');
    Route::get('/{id}/edit', 'RoleController@edit')->name('role.edit');
    Route::put('/{id}', 'RoleController@update')->name('role.update');
    Route::get('/{id}/hapus', 'RoleController@hapus')->name('role.hapus');
});
