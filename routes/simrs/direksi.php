<?php

Route::get('/direksi/updateKamarFolio', 'DireksiController@updateKamarFolio');
Route::get('/direksi/direksiNoRm', 'DireksiController@direksiNoRm');
Route::view('/direksi/laporan', 'direksi.laporan');
Route::get('/direksi/laporan-kinerja', 'DireksiController@laporanKinerja');
Route::post('/direksi/laporan-kinerja', 'DireksiController@laporanKinerjaByTanggal');

Route::get('/direksi/laporan-tagihan', 'DireksiController@tagihan');
Route::get('/direksi/laporan-pendapatan-new', 'DireksiController@pendapatanNew');
Route::post('/direksi/laporan-pendapatan-new', 'DireksiController@viewPendapatanNew');

Route::get('/direksi/exportExcel/{tga}/{tgb}/{unit}/{lunas}', 'DireksiController@exportExcel');

Route::get('/direksi/laporan-pendapatan', 'DireksiController@pendapatan');
Route::post('/direksi/laporan-pendapatan', 'DireksiController@viewPendapatan');
Route::get('/direksi/laporan-penerimaan', 'DireksiController@penerimaan');
Route::post('/direksi/laporan-penerimaan', 'DireksiController@viewPenerimaan');
Route::get('/direksi/laporan-penunjang', 'DireksiController@penunjang');
Route::post('/direksi/laporan-penunjang', 'DireksiController@viewPenunjang');
Route::get('/direksi/laporan-pem-uang-muka', 'DireksiController@uangmuka');
Route::get('/direksi/laporan-bridging-jkn', 'DireksiController@bridgingjkn');
Route::get('/direksi/laporan-selisih-negatif', 'DireksiController@selisihnegatif');
Route::get('/direksi/laporan-naik-kelas', 'DireksiController@naikkelas');
Route::get('/direksi/laporan-pasien', 'DireksiController@lapPasien');
Route::post('/direksi/laporan-pasien', 'DireksiController@viewLapPasien');
Route::get('/direksi/json-pasien', 'DireksiController@viewLapPasien');
Route::get('/direksi/laporan-tindakan', 'DireksiController@LapTindakan');
Route::post('/direksi/laporan-tindakan', 'DireksiController@LapTindakan_by');

Route::get('/direksi/laporan-tindakan-umum', 'DireksiController@LapTindakanUmum');
Route::post('/direksi/laporan-tindakan-umum', 'DireksiController@LapTindakanUmum_by');

//Kinerja Rawat Jalan
Route::get('/direksi/kinerja-rawat-jalan', 'DireksiController@kinerjaRawatJalan');
Route::post('/direksi/kinerja-rawat-jalan', 'DireksiController@kinerjaRawatJalanByDate');
Route::get('/direksi/detail-kinerja-rawat-jalan/{dokter_id}/{cara_bayar_id}/{mapping}', 'DireksiController@detailKinerjaRawatJalan');

//Kinerja Rawat Darurat
Route::get('/direksi/kinerja-rawat-darurat', 'DireksiController@kinerjaRawatDarurat');
Route::post('/direksi/kinerja-rawat-darurat', 'DireksiController@kinerjaRawatDaruratByDate');
Route::get('/direksi/detail-kinerja-rawat-darurat/{dokter_id}/{cara_bayar_id}/{mapping}', 'DireksiController@detailKinerjaRawatDarurat');

//Kinerja Rawat Inap
Route::get('/direksi/kinerja-rawat-inap', 'DireksiController@kinerjaRawatInap');
Route::post('/direksi/kinerja-rawat-inap', 'DireksiController@kinerjaRawatInapByDate');
Route::get('/direksi/detail-kinerja-rawat-inap/{dokter_id}/{cara_bayar_id}/{mapping}', 'DireksiController@detailKinerjaRawatInap');

//Laporan LOS
Route::get('/direksi/laporan-los', 'DireksiController@laporanLOS');
Route::post('/direksi/laporan-los', 'DireksiController@viewLOS');

// laporan kunjungan
Route::get('/direksi/laporan/pengunjung/igd', 'DireksiLaporanController@indexIgd');
Route::post('/direksi/laporan/pengunjung/igd', 'DireksiLaporanController@filterIgd');
Route::get('/direksi/laporan/pengunjung/inap', 'DireksiLaporanController@indexInap');
Route::post('/direksi/laporan/pengunjung/inap', 'DireksiLaporanController@filterInap');
Route::get('/direksi/laporan/pengunjung/jalan', 'DireksiLaporanController@indexJalan');
Route::post('/direksi/laporan/pengunjung/jalan', 'DireksiLaporanController@filterJalan');

// TRANSAKSI KELUAR
Route::get('/direksi/laporan-transaksi-keluar', 'DireksiController@laporanTransaksiKeluar');
Route::post('/direksi/laporan-transaksi-keluar', 'DireksiController@viewLaporanTransaksiKeluar');
