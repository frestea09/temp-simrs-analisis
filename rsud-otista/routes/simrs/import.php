<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::view('cari-file-pasien','import.pasien');
  Route::view('cari-file-province','import.province');
  Route::view('cari-file-ris','import.ris');
  Route::view('cari-file-lis','import.lis');
  Route::view('cari-file-batch','import.batch');
  Route::view('cari-file-biodata','import.biodata');
  Route::view('cari-file-pegawai','import.pegawai');
  Route::view('cari-file-irj','import.irj');
  Route::view('cari-filetarif-new','import.tarifnew');
  Route::view('cari-file-irna','import.irna');
  Route::view('cari-file-igd','import.igd');
  Route::view('cari-file-icd9','import.icd9');
  Route::view('cari-file-icd10','import.icd10');

  Route::get('template-pasien', 'ImportController@templatePasien')->name('template-pasien');
  Route::get('template-pegawai', 'ImportController@templatePegawai')->name('template-pegawai');
  Route::get('template-irj', 'ImportController@templateIrj')->name('template-irj');
  Route::get('template-igd', 'ImportController@templateIGD')->name('template-igd');
  Route::get('template-irna', 'ImportController@templateIrna')->name('template-irna');
  Route::get('template-icd9', 'ImportController@templateIcd9')->name('template-icd9');
  Route::get('template-icd10', 'ImportController@templateIcd10')->name('template-icd10');

  Route::post('/import-pasien','ImportController@importPasien')->name('import-pasien');
  Route::post('/import-biodata','ImportController@importBiodata')->name('import-biodata');
  Route::post('/import-province','ImportController@importProvince')->name('import-province');
  Route::post('/import-pegawai','ImportController@importPegawai')->name('import-pegawai');
  Route::post('/import-irj','ImportController@importIrj')->name('import-irj');
  Route::post('/import-tarifnew','ImportController@importTarifNew')->name('import-tarifnew');
  Route::post('/import-irna','ImportController@importIrna')->name('import-irna');
  Route::post('/import-igd','ImportController@importIgd')->name('import-igd');
  Route::post('/import-icd9','ImportController@importIcd9')->name('import-icd9');
  Route::post('/import-icd10','ImportController@importIcd10')->name('import-icd10');
  Route::post('/import-ris','ImportController@importRis')->name('import-ris');
  Route::post('/import-lis','ImportController@importLis')->name('import-lis');
  Route::post('/import-batch','ImportController@importBatch')->name('import-batch');

  Route::get('getKatTarif/{kategoriheader_id}', 'ImportController@getKatTarif');
});