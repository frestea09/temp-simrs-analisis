<?php

Route::group(['middleware' => ['web', 'auth']], function () {

	//tindakanIRJ
	Route::post('ris/store', 'RisController@store');
	Route::get('ris/get-tindakan', 'RisController@getTindakan');
	Route::get('ris/get-modality', 'RisController@getModality');
	Route::get('ris/get-tarif-ris', 'RisController@getTarifRis');
	Route::get('ris/get-token', 'RisController@token');
	Route::get('ris/getexam/{rm}', 'RisController@getexam');
	Route::get('ris/getPdf/{rm}/{assessementid}', 'RisController@getPdf');
	Route::get('ris/getexam-response/{rm}', 'RisController@getexamResp');
	Route::get('ris/getexamonassessment/{rm}/{assid}', 'RisController@getexamonassessment');
	Route::get('ris/getexamwaitingreport/{rm}/{assid}', 'RisController@getexamwaitingreport');
	Route::get('ris/getpdfreport/{rm}/{assid}', 'RisController@getpdfreport');
	Route::get('ris/test-ris/{rm}/{assid}', 'RisController@getexamonassessment');

});
