<?php

Route::group(['middleware' => ['web', 'auth']], function () {
  Route::view('pemulasaran-jenazah/penata_jasa', 'pemulasaran-jenazah.penata_jasa');
  Route::view('pemulasaran-jenazah/laporan', 'pemulasaran-jenazah.laporan');

  Route::get('pemulasaran-jenazah/pasien-langsung', 'PemulasaranController@pasienLangsung');
  Route::get('pemulasaran-jenazah/laporan-pengunjung', 'PemulasaranController@laporanPengunjung');
  Route::post('pemulasaran-jenazah/laporan-pengunjung', 'PemulasaranController@filterLaporan');

  Route::get('pemulasaran-jenazah/entry-ambulans-langsung/{reg_id}', 'PemulasaranController@entryAmbulansLangsung');
  Route::post('pemulasaran-jenazah/save-tindakan-langsung', 'PemulasaranController@simpanTindakanLangsung');

  Route::get('pemulasaran-jenazah/tindakan-rajal', 'PemulasaranController@tindakanRajal');
  Route::get('pemulasaran-jenazah/tindakan-ranap', 'PemulasaranController@tindakanRanap');
  Route::get('pemulasaran-jenazah/tindakan-darurat', 'PemulasaranController@tindakanDarurat');

  Route::post('pemulasaran-jenazah/tindakan-rajal', 'PemulasaranController@filterTindakanRajal');
  Route::post('pemulasaran-jenazah/tindakan-ranap', 'PemulasaranController@filterTindakanRanap');
  Route::post('pemulasaran-jenazah/tindakan-darurat', 'PemulasaranController@filterTindakanDarurat');
  
  Route::get('pemulasaran-jenazah/insert-tindakan/{jenis}/{unit}/{reg}/{pasien}', 'PemulasaranController@insertTindakan');

  Route::post('pemulasaran-jenazah/save-tindakan', 'PemulasaranController@saveTindakan');

  Route::get('pemulasaran-jenazah/cetak-tindakan/{unit}/{reg_id}', 'PemulasaranController@cetakTindakan');
  Route::get('pemulasaran-jenazah/hapus-tindakan/{fol}/{fol_id}', 'PemulasaranController@hapusTindakan');

  Route::post('pemulasaran-jenazah/lunas-tindakan', 'PemulasaranController@lunaskanTindakan');
  Route::post('pemulasaran-jenazah/belum-lunas-tindakan', 'PemulasaranController@belumLunaskanTindakan');

  Route::get('pemulasaran-jenazah/ceck-tarif', 'PemulasaranController@ceckTarif');
});
