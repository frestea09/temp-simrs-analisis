<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('tahuntarif','TahuntarifController@index')->name('tahuntarif');
  Route::get('tahuntarif/create','TahuntarifController@create')->name('tahuntarif.create');
  Route::get('tahuntarif/{id}/edit','TahuntarifController@edit')->name('tahuntarif.edit');
  Route::post('tahuntarif/store','TahuntarifController@store')->name('tahuntarif.store');
  Route::put('tahuntarif/{id}','TahuntarifController@update')->name('tahuntarif.update');
});
