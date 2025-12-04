<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'tarif', 'namespace' => 'Modules\Tarif\Http\Controllers'], function()
{
    //Tarif Irna
    Route::get('/', 'TarifController@index')->name('tarif');
    Route::post('/irna-by-request', 'TarifController@irnaByRequest')->name('tarif.irna-by-request');
    
    Route::get('/create/{ta?}', 'TarifController@create')->name('tarif.create');
    Route::post('/store', 'TarifController@store')->name('tarif.store');
    Route::get('/{id}/edit/{ta?}', 'TarifController@edit')->name('tarif.edit');
    Route::put('/{id}', 'TarifController@update')->name('tarif.update');
    Route::get('/cek-split/{id}', 'TarifController@cek_split');
    
    //Tarif IRJ
    Route::post('/by-kategori-header', 'TarifController@byKategoriHeader')->name('tarif.by-kategori-header');
    Route::get('rawatjalan/{thntarif_id?}/{kategoriheader_id?}', 'TarifController@tarif_rawatjalan');
    //Tarif IGD
    Route::post('/rawatdarurat-by-kategori-header', 'TarifController@igdByKategoriHeader')->name('tarif.rawatdarurat-by-kategori-header');
    Route::get('rawatdarurat/{thntarif_id?}/{kategoriheader_id?}', 'TarifController@tarif_darurat')->name('tarif.rawatdarurat');

    //Tarif IRNA
    Route::post('/irna-by-kategori-header', 'TarifController@irnaByKategoriHeader')->name('tarif.irna-by-kategori-header');
    Route::get('irna/{thntarif_id?}/{kategoriheader_id?}', 'TarifController@tarif_irna')->name('tarif.irna');
 
    Route::post('/update-inhealth', 'TarifController@updateInhealth');

    Route::get('/tampil-semua-tarif', 'TarifController@alltarif');
    Route::post('/tampil-jenis-tarif', 'TarifController@alltarifby');

    Route::get('/export-all', 'TarifController@exportAllTarif');
    Route::get('/export-tarif-lab', 'TarifController@exportTarifLab');
});
