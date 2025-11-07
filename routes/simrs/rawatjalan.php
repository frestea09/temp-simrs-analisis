<?php
Route::group(['middleware'=>['web','auth'], 'prefix' => 'rawat-jalan'], function () {
  Route::view('/billing', 'rawat-jalan.billing');
  Route::view('/emr', 'rawat-jalan.emr');
  Route::view('/laporan', 'rawat-jalan.laporan');
  Route::view('/laboratorium', 'rawat-jalan.laboratorium');
  Route::view('/radiologi', 'rawat-jalan.radiologi');
});
