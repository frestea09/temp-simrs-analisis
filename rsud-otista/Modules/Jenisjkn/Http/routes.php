<?php

Route::group(['middleware' => 'web', 'prefix' => 'jenisjkn', 'namespace' => 'Modules\Jenisjkn\Http\Controllers'], function()
{
    Route::get('/', 'JenisjknController@index');
});
