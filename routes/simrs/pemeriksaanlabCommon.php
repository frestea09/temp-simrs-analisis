<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('pemeriksaanlabCommon', 'PemeriksaanLabCommonController@index');
  Route::post('pemeriksaanlabCommon', 'PemeriksaanLabCommonController@index_byTanggal');
  Route::get('pemeriksaanlabCommon/create/{id?}/{labid?}', 'PemeriksaanLabCommonController@create');
  Route::post('pemeriksaanlabCommon/store', 'PemeriksaanLabCommonController@store');
  Route::post('pemeriksaanlabCommon/store-lis', 'PemeriksaanLabCommonController@storeLis');
  Route::post('pemeriksaanlabCommon/saverincian', 'PemeriksaanLabCommonController@save_rincian');
  Route::get('pemeriksaanlabCommon/cetak/{registrasi_id?}/{hasillab_id}', 'PemeriksaanLabCommonController@cetak_hasil_lab');

  Route::get('pemeriksaanlabCommon/getkategori/{id}', 'PemeriksaanLabCommonController@get_kategori');
  Route::get('pemeriksaanlabCommon/getlab/{id}', 'PemeriksaanLabCommonController@get_laboratoria');
  Route::get('pemeriksaanlabCommon/deletedetail/{registrasi_id}/{lab_id}/{id}', 'PemeriksaanLabCommonController@deleteDetail');

  Route::get('pemeriksaanlabCommon/cetakAll/{registrasi_id?}', 'PemeriksaanLabCommonController@cetakAllLab');
  Route::get('pemeriksaanlabCommon/cetakRujukan/{registrasi_id?}', 'PemeriksaanLabCommonController@cetakRujukanLab');
  Route::get('pemeriksaanlabCommon/cetakAll-vedika/{registrasi_id?}', 'PemeriksaanLabCommonController@cetakAllLabvedika');

  // tampilkan hasil lab di pengorder
  Route::get('pemeriksaanlabCommon/pasien/{registrasi_id?}', 'PemeriksaanLabCommonController@lihatHasil');

  Route::get('pemeriksaanlabCommon/hapus/{id}', 'PemeriksaanLabCommonController@hapus');

  // PASIEN LANGSUNG
  Route::get('pemeriksaanlabCommon/create-pasien-langsung/{id?}/{labid?}', 'PemeriksaanLabCommonController@createPasienLangsung');
  Route::post('pemeriksaanlabCommon/store-pasien-langsung', 'PemeriksaanLabCommonController@storePasienLangsung');
  Route::get('pemeriksaanlabCommon/cetak-pasien-langsung/{registrasi_id?}/{hasillab_id}', 'PemeriksaanLabCommonController@cetak_hasil_labPasienLangsung');

  Route::get('pemeriksaanlabCommon/cari-pasien', 'PemeriksaanLabCommonController@cariPasien');
	Route::post('pemeriksaanlabCommon/cari-pasien', 'PemeriksaanLabCommonController@cariPasienProses');

  // TTE
	Route::post('pemeriksaanlabCommon/tte-hasil-lab/{id}', 'PemeriksaanLabCommonController@tteHasilLab');


});
