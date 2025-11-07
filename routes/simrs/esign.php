<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('esign/log', 'EsignController@log');

  Route::post('save_passphrase', 'EsignController@userPassphrase');
});
