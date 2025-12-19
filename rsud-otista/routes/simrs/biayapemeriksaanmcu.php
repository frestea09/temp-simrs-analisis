<?php

 Route::get('biayapemeriksaanmcu','BiayaPemeriksaanMCUController@index')->name('biayapemeriksaanmcu');
 Route::get('biayapemeriksaanmcu/{id}/edit','BiayaPemeriksaanMCUController@edit')->name('biayapemeriksaanmcu.edit');
 Route::post('biayapemeriksaanmcu/store','BiayaPemeriksaanMCUController@store')->name('biayapemeriksaanmcu.store');
 Route::put('biayapemeriksaanmcu/{id}','BiayaPemeriksaanMCUController@update')->name('biayapemeriksaanmcu.update');
 Route::get('biayapemeriksaanmcu/create','BiayaPemeriksaanMCUController@create')->name('biayapemeriksaanmcu.create');
 Route::get('biayapemeriksaanmcu/{id}/delete','BiayaPemeriksaanMCUController@destroy')->name('biayapemeriksaanmcu.delete');
 Route::post('biayapemeriksaanmcu/addtarif/{id}','BiayaPemeriksaanMCUController@storeTarif')->name('biayapemeriksaanmcu.storeTarif');
 Route::get('biayapemeriksaanmcu/removetarif/{id}','BiayaPemeriksaanMCUController@removeTarif')->name('biayapemeriksaanmcu.removeTarif');
