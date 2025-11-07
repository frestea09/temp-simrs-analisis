<?php

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('rekap-laporan/rawat-darurat', 'RekapLaporanController@rawatDarurat');

    Route::get('rekap-laporan/gigi-mulut', 'RekapLaporanController@gigiMulut');
    Route::post('rekap-laporan/gigi-mulut', 'RekapLaporanController@updateRl33');
    Route::get('rekap-laporan/gigi-mulut/toExcel', 'RekapLaporanController@toExcel');
    Route::get('rekap-laporan/gigi-mulut/mapping/{id}', 'RekapLaporanController@gigiMulutMapping');

    Route::get('rekap-laporan/pembedahan', 'RekapLaporanController@pembedahan');
    Route::post('rekap-laporan/pembedahan', 'RekapLaporanController@updateRl36');
    Route::get('rekap-laporan/pembedahan/toExcel', 'RekapLaporanController@toExcelPembedahan');
    Route::get('rekap-laporan/pembedahan/mapping/{id}', 'RekapLaporanController@PembedahanMapping');

    Route::get('rekap-laporan/mapping-detail/{type}/{id}', 'RekapLaporanController@mappingDetail');
    Route::get('rekap-laporan/hapus-mapping/{type}/{id}', 'RekapLaporanController@hapusMapping');
    Route::get('rekap-laporan/data-tarif/{type}/{rl33_id}/{tahuntarif_id?}/{jenis?}', 'RekapLaporanController@dataTarif');
    Route::post('rekap-laporan/save-mapping', 'RekapLaporanController@saveMapping');
});