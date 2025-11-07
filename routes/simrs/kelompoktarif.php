<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('kelompoktarif','KelompoktarifController@index')->name('kelompoktarif');
  Route::get('kelompoktarif/create','KelompoktarifController@create')->name('kelompoktarif.create');
  Route::get('kelompoktarif/{id}/edit','KelompoktarifController@edit')->name('kelompoktarif.edit');
  Route::post('kelompoktarif/store','KelompoktarifController@store')->name('kelompoktarif.store');
  Route::put('kelompoktarif/{id}','KelompoktarifController@update')->name('kelompoktarif.update');
});
