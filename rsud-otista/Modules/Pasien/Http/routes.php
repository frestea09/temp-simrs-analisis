<?php


Route::group(['middleware' => ['web','auth'], 'prefix' => 'pasien', 'namespace' => 'Modules\Pasien\Http\Controllers'], function()
{
    Route::get('/rekam-medis', 'PasienController@index_rekamMedis');
    Route::get('/riwayat-status-pasien', 'PasienController@riwayatStatusPasien');
    Route::get('/get-data/rekam-medis', 'PasienController@rekamMedis_source');
    Route::get('/', 'PasienController@index')->name('pasien');
    Route::get('/create', 'PasienController@create')->name('pasien.create');
    Route::post('/store', 'PasienController@store')->name('pasien.store');
    Route::get('/{id}/edit', 'PasienController@edit')->name('pasien.edit');
    Route::put('/{id}', 'PasienController@update')->name('pasien.update');
    Route::get('/getkota/{province_id}', 'PasienController@getKabupaten');
    Route::get('/getdistrict/{regency_id}', 'PasienController@getKecamatan');
    Route::get('/getdesa/{district_id}', 'PasienController@getDesa');
    Route::get('/{id}/show', 'PasienController@show');
    Route::post('/search', 'PasienController@search')->name('pasien.search');
    
    Route::get('getdata-datatable', 'PasienController@getData');
    Route::get('search-pasien/{antrian_id}/{no_loket}', 'PasienController@searchPasien');
    Route::get('search-pasien-igd/', 'PasienController@searchPasienIGD');
    Route::post('/search-pasien-igd-filter', 'PasienController@searchFilterPasienIGD');
    Route::get('search-pasien-ranap/', 'PasienController@searchPasienRanap');
    
    Route::get('master-pasien/', 'PasienController@getMasterPasien');
    
    Route::get('/getbpjsprov/{prov_kode}', 'PasienController@getBpjsProv');
    Route::get('/getbpjskab/{kab_kode}', 'PasienController@getBpjsKab');
    Route::get('/getbpjskec/{kec_kode}', 'PasienController@getBpjsKec');

    Route::get('/info-pasien', 'PasienController@InfoData');
    Route::get('getdata-datatable-info', 'PasienController@getDataInfo');

    Route::get('/getkota2/{province_id}', 'PasienController@getKabupaten2');
    Route::get('/getdistrict2/{regency_id}', 'PasienController@getKecamatan2');
    Route::get('/getdesa2/{district_id}', 'PasienController@getDesa2');
});
