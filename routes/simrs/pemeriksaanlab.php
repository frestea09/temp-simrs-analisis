<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('pemeriksaanlab', 'PemeriksaanLabController@index');
  Route::post('pemeriksaanlab', 'PemeriksaanLabController@index_byTanggal');
  Route::get('pemeriksaanlab/create/{id?}/{labid?}', 'PemeriksaanLabController@create');
  Route::post('pemeriksaanlab/store', 'PemeriksaanLabController@store');
  Route::post('pemeriksaanlab/store-lis', 'PemeriksaanLabController@storeLis');
  Route::post('pemeriksaanlab/store-none-lis', 'PemeriksaanLabController@storeNoneLis');
  Route::post('pemeriksaanlab/store-none-lis-new', 'PemeriksaanLabController@storeNoneLisNew');
  Route::post('pemeriksaanlab/saveOrderPA', 'PemeriksaanLabController@saveOrderPA');
  Route::post('pemeriksaanlab/saverincian', 'PemeriksaanLabController@save_rincian');
  Route::get('pemeriksaanlab/cetak/{registrasi_id?}/{hasillab_id}', 'PemeriksaanLabController@cetak_hasil_lab');

  Route::get('pemeriksaanlab/get-pemeriksaan-lab/{id}', 'PemeriksaanLabController@getPemeriksaanLab');

  Route::get('pemeriksaanlab/getkategori/{id}', 'PemeriksaanLabController@get_kategori');
  Route::get('pemeriksaanlab/getlab/{id}', 'PemeriksaanLabController@get_laboratoria');
  Route::get('pemeriksaanlab/deletedetail/{registrasi_id}/{lab_id}/{id}', 'PemeriksaanLabController@deleteDetail');

  Route::get('pemeriksaanlab/cetakAll/{registrasi_id?}', 'PemeriksaanLabController@cetakAllLab');
  Route::get('pemeriksaanlab/cetakAll-lis/{registrasi_id?}', 'PemeriksaanLabController@cetakAllLabLis');
  Route::post('pemeriksaanlab/cetakAll-lis/tte/{registrasi_id?}', 'PemeriksaanLabController@tteCetakAllLabLis');
  Route::get('pemeriksaanlab/cetakAll-lis-tte/{registrasi_id?}', 'PemeriksaanLabController@cetakAllLabLisTTE');
  Route::get('pemeriksaanlab/cetakRujukan/{registrasi_id?}', 'PemeriksaanLabController@cetakRujukanLab');
  Route::get('pemeriksaanlab/cetakAll-vedika/{registrasi_id?}', 'PemeriksaanLabController@cetakAllLabvedika');

  // tampilkan hasil lab di pengorder
  Route::get('pemeriksaanlab/pasien/{registrasi_id?}', 'PemeriksaanLabController@lihatHasil');

  Route::get('pemeriksaanlab/hapus/{id}', 'PemeriksaanLabController@hapus');

  // PASIEN LANGSUNG
  Route::get('pemeriksaanlab/create-pasien-langsung/{id?}/{labid?}', 'PemeriksaanLabController@createPasienLangsung');
  Route::post('pemeriksaanlab/store-pasien-langsung', 'PemeriksaanLabController@storePasienLangsung');
  Route::get('pemeriksaanlab/cetak-pasien-langsung/{registrasi_id?}/{hasillab_id}', 'PemeriksaanLabController@cetak_hasil_labPasienLangsung');

  Route::get('pemeriksaanlab/cari-pasien', 'PemeriksaanLabController@cariPasien');
	Route::post('pemeriksaanlab/cari-pasien', 'PemeriksaanLabController@cariPasienProses');

});
