<?php

 Route::get('biayapemeriksaanfarmasi','BiayaPemeriksaanFarmasiController@index')->name('biayapemeriksaanfarmasi');
 Route::get('biayapemeriksaanfarmasi/{id}/edit','BiayaPemeriksaanFarmasiController@edit')->name('biayapemeriksaanfarmasi.edit');
 Route::post('biayapemeriksaanfarmasi/store','BiayaPemeriksaanFarmasiController@store')->name('biayapemeriksaanfarmasi.store');
 Route::put('biayapemeriksaanfarmasi/{id}','BiayaPemeriksaanFarmasiController@update')->name('biayapemeriksaanfarmasi.update');
 Route::get('biayapemeriksaanfarmasi/create','BiayaPemeriksaanFarmasiController@create')->name('biayapemeriksaanfarmasi.create');
 Route::get('biayapemeriksaanfarmasi/{id}/delete','BiayaPemeriksaanFarmasiController@destroy')->name('biayapemeriksaanfarmasi.delete');
 Route::post('biayapemeriksaanfarmasi/addobat/{id}','BiayaPemeriksaanFarmasiController@storeObat')->name('biayapemeriksaanfarmasi.storeObat');
 Route::get('biayapemeriksaanfarmasi/removeobat/{id}','BiayaPemeriksaanFarmasiController@removeObat')->name('biayapemeriksaanfarmasi.removeObat');
