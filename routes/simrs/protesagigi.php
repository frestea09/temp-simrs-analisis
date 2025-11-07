<?php

Route::group(['middleware' => ['web', 'auth']], function () {
  Route::view('protesa-gigi/penata_jasa', 'protesa-gigi.penata_jasa');
  Route::view('protesa-gigi/laporan', 'protesa-gigi.laporan');

  Route::get('protesa-gigi/pasien-langsung', 'ProtesaGigiController@pasienLangsung');
  Route::get('protesa-gigi/laporan-pengunjung', 'ProtesaGigiController@laporanPengunjung');
  Route::post('protesa-gigi/laporan-pengunjung', 'ProtesaGigiController@filterLaporan');

  Route::get('protesa-gigi/entry-langsung/{reg_id}', 'ProtesaGigiController@entryLangsung');
  Route::post('protesa-gigi/save-tindakan-langsung', 'ProtesaGigiController@simpanTindakanLangsung');

  Route::get('protesa-gigi/tindakan-rajal', 'ProtesaGigiController@tindakanRajal');
  Route::get('protesa-gigi/tindakan-ranap', 'ProtesaGigiController@tindakanRanap');
  Route::get('protesa-gigi/tindakan-darurat', 'ProtesaGigiController@tindakanDarurat');

  Route::post('protesa-gigi/tindakan-rajal', 'ProtesaGigiController@filterTindakanRajal');
  Route::post('protesa-gigi/tindakan-ranap', 'ProtesaGigiController@filterTindakanRanap');
  Route::post('protesa-gigi/tindakan-darurat', 'ProtesaGigiController@filterTindakanDarurat');
  
  Route::get('protesa-gigi/insert-tindakan/{unit}/{reg}/{pasien}', 'ProtesaGigiController@insertTindakan');

  Route::post('protesa-gigi/save-tindakan', 'ProtesaGigiController@saveTindakan');

  Route::get('protesa-gigi/cetak-tindakan/{unit}/{reg_id}', 'ProtesaGigiController@cetakTindakan');
  Route::get('protesa-gigi/hapus-tindakan/{fol}/{fol_id}', 'ProtesaGigiController@hapusTindakan');

  Route::post('protesa-gigi/lunas-tindakan', 'ProtesaGigiController@lunaskanTindakan');
  Route::post('protesa-gigi/belum-lunas-tindakan', 'ProtesaGigiController@belumLunaskanTindakan');

  Route::get('protesa-gigi/ceck-tarif', 'ProtesaGigiController@ceckTarif');
});
