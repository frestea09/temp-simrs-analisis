<?php

 Route::get('biayaregistrasi','BiayaregistrasiController@index')->name('biayaregistrasi');
 Route::get('biayaregistrasi/{id}/edit','BiayaregistrasiController@edit')->name('biayaregistrasi.edit');
 Route::post('biayaregistrasi/store','BiayaregistrasiController@store')->name('biayaregistrasi.store');
 Route::put('biayaregistrasi/{id}','BiayaregistrasiController@update')->name('biayaregistrasi.update');
 Route::get('biayaregistrasi/create','BiayaregistrasiController@create')->name('biayaregistrasi.create');
