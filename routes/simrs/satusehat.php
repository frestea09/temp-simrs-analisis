<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('/satusehat/create-kyc', 'SatuSehatController@createKyc');
  Route::post('satusehat/kyc', 'SatuSehatController@kyc');
  Route::post('satusehat/test', 'SatuSehatController@test');


  Route::get('satusehat/log-encounter', 'SatuSehatController@logEncounter');
  Route::get('satusehat/dashboard', 'SatuSehatController@dashboard');
  Route::get('satusehat/json', 'SatuSehatController@json');
  Route::get('satusehat-request/json', 'SatuSehatController@jsonRequest');
  Route::get('log-ris', 'SatuSehatController@logRis');
  Route::get('ris-json', 'SatuSehatController@jsonRis');
  
  Route::get('log-lica', 'SatuSehatController@logLica');
  Route::get('lica-json', 'SatuSehatController@jsonLica');

  Route::get('kirim_ulang_encounter/{reg_id}', 'SatuSehatController@kirimUlang');
});
