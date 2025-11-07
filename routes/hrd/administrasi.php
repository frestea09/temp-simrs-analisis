<?php

//  Route::view('/hrd/administrasi', 'hrd.administrasi.index')->name('administrasi.index');

Route::group(['prefix' => 'hrd/administrasi'], function () {

    // SURAT MASUK
    Route::group(['prefix' => 'surat-masuk'], function () {
        Route::get('/', 'HRD\AdministrasiController@suratMasuk');
        Route::get('create/{id?}', 'HRD\AdministrasiController@createSuratMasuk');
        Route::get('delete/{id?}', 'HRD\AdministrasiController@deleteSuratMasuk');
        Route::post('save', 'HRD\AdministrasiController@saveSuratMasuk');
        Route::get('preview/{id}', 'HRD\AdministrasiController@previewSuratMasuk');
        Route::post('byTanggal', 'HRD\AdministrasiController@suratMasukByTanggal')->name('administrasi.data');
    });

    // PRODUK HUKUM
    Route::group(['prefix' => 'produk-hukum'], function () {
        Route::get('/', 'HRD\AdministrasiController@produkHukum');
        Route::get('create/{id?}', 'HRD\AdministrasiController@createProdukHukum');
        Route::get('delete/{id?}', 'HRD\AdministrasiController@deleteProdukHukum');
        Route::post('save', 'HRD\AdministrasiController@saveProdukHukum');
        Route::get('preview/{id}', 'HRD\AdministrasiController@previewProdukHukum');
        Route::post('byTanggal', 'HRD\AdministrasiController@produkHukumByTanggal');
    });

     // LAINNYA
     Route::group(['prefix' => 'lain'], function () {
        Route::get('/', 'HRD\AdministrasiController@lain');
        Route::get('create/{id?}', 'HRD\AdministrasiController@createLain');
        Route::get('delete/{id?}', 'HRD\AdministrasiController@deleteLain');
        Route::post('save', 'HRD\AdministrasiController@saveLain');
        Route::get('preview/{id}', 'HRD\AdministrasiController@previewLain');
        Route::post('byTanggal', 'HRD\AdministrasiController@lainByTanggal');
    });

});
    