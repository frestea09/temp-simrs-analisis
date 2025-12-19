<?php

 Route::get('biayapemeriksaan','BiayaPemeriksaanController@index')->name('biayapemeriksaan');
 Route::get('biayapemeriksaan/{id}/edit','BiayaPemeriksaanController@edit')->name('biayapemeriksaan.edit');
 Route::post('biayapemeriksaan/store','BiayaPemeriksaanController@store')->name('biayapemeriksaan.store');
 Route::put('biayapemeriksaan/{id}','BiayaPemeriksaanController@update')->name('biayapemeriksaan.update');
 Route::get('biayapemeriksaan/create','BiayaPemeriksaanController@create')->name('biayapemeriksaan.create');
 Route::get('biayapemeriksaan/{id}/delete','BiayaPemeriksaanController@destroy')->name('biayapemeriksaan.delete');
