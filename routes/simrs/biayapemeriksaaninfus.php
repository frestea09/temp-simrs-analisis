<?php

 Route::get('biayapemeriksaaninfus','BiayaPemeriksaanInfusController@index')->name('biayapemeriksaaninfus');
 Route::get('biayapemeriksaaninfus/{id}/edit','BiayaPemeriksaanInfusController@edit')->name('biayapemeriksaaninfus.edit');
 Route::post('biayapemeriksaaninfus/store','BiayaPemeriksaanInfusController@store')->name('biayapemeriksaaninfus.store');
 Route::put('biayapemeriksaaninfus/{id}','BiayaPemeriksaanInfusController@update')->name('biayapemeriksaaninfus.update');
 Route::get('biayapemeriksaaninfus/create','BiayaPemeriksaanInfusController@create')->name('biayapemeriksaaninfus.create');
 Route::get('biayapemeriksaaninfus/{id}/delete','BiayaPemeriksaanInfusController@destroy')->name('biayapemeriksaaninfus.delete');
 Route::post('biayapemeriksaaninfus/addtarif/{id}','BiayaPemeriksaanInfusController@storeTarif')->name('biayapemeriksaaninfus.storeTarif');
 Route::get('biayapemeriksaaninfus/removetarif/{id}','BiayaPemeriksaanInfusController@removeTarif')->name('biayapemeriksaaninfus.removeTarif');
