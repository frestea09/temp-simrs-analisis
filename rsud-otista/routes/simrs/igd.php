<?php
Route::group(['middleware'=>['web','auth','role:rawatdarurat|administrator']], function () {
  Route::view('igd/billing', 'igd.billing');
  Route::view('igd/laboratorium', 'igd.laboratorium');
  Route::view('igd/radiologi', 'igd.radiologi');
  Route::view('igd/emr', 'igd.emr');
  Route::view('igd/askep', 'igd.askep');
  Route::view('igd-laporan', 'igd.laporan');
  
  Route::get('igd/laporan-pengunjung', 'IgdController@lap_pengunjung');
  Route::post('igd-laporan-pengunjung', 'IgdController@lap_pengunjung_byRequest');
  Route::get('igd/test/{reg?}', 'IgdController@test');
  
  Route::get('igd/transit', 'IgdController@transit');
  Route::post('igd/transit', 'IgdController@filterTransit');
  Route::get('igd/entry-tindakan-transit/{reg}/{pasien}', 'IgdController@entryTindakanTransit');
  Route::post('igd/save-entry-transit', 'IgdController@saveEntryTransit');
  Route::post('igd/save-kondisi-transit', 'IgdController@saveKondisiTransit');


  Route::get('igd/laporan-kunjungan', 'IgdController@lap_kunjungan');
  Route::post('igd-laporan-kunjungan', 'IgdController@lap_kunjungan_byRequest');

  Route::get('igd/cari-pasien', 'IgdController@cariPasien');
	Route::post('igd/cari-pasien', 'IgdController@cariPasienProses');
  // Route::post('igd/laporan-kunjungan', 'IgdController@lap_kunjungan_byRequest');

});
