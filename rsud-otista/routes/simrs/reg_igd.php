<?php
//REG IGD
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('regigd','RegistrasiController@reg_igd');
});
