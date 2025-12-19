<?php
Route::view('copy-resep', 'farmasi.copy-resep');
// Route::get('copy-resep', 'CopyResepController@index');
Route::get('copy-resep/jalan', 'CopyResepController@indexRajal');
Route::post('copy-resep/jalan', 'CopyResepController@indexRajalBy');
Route::get('copy-resep/darurat', 'CopyResepController@indexDarurat');
Route::post('copy-resep/darurat', 'CopyResepController@indexDaruratBy');
Route::get('copy-resep/irna', 'CopyResepController@indexIrna');
Route::post('copy-resep/irna', 'CopyResepController@indexIrnaBy');
Route::get('copy-resep/penjualanbebas', 'CopyResepController@indexBebas');
Route::post('copy-resep/penjualanbebas', 'CopyResepController@indexBebasBy');
Route::get('copy-resep/rujukan', 'CopyResepController@indexRujukan');
Route::post('copy-resep/rujukan', 'CopyResepController@indexRujukanBy');
Route::get('copy-resep/{id}/history', 'CopyResepController@history');

//get data

Route::get('copy-resep/get-obat/{id}', 'CopyResepController@getDataMasterObat');


//simpan penjualan
Route::get('copy-resep/form-penjualan/{idpasien?}/{idreg?}/{penjualan_id?}', 'CopyResepController@form_penjualan');
Route::get('copy-resep/form-edit-penjualan/{idpasien?}/{idreg?}/{penjualan_id?}', 'CopyResepController@form_edit_penjualan');
Route::post('copy-resep/simpan-penjualan-detail', 'CopyResepController@saveDetail');
Route::get('copy-resep/deleteDetail/{id}/{idpasien?}/{idreg?}/{penjualan_id?}', 'CopyResepController@deleteDetail');
Route::post('copy-resep/simpan-total-penjualan', 'CopyResepController@saveTotal');
Route::post('copy-resep/simpan-surat-rujukan', 'CopyResepController@saveSuratRujukan');

//PENJUALAN BEBAS BARU
Route::post('copy-resep/savepenjualanbebas', 'CopyResepController@save_penjualan_bebas_baru');
Route::get('copy-resep/formpenjualanbebasbaru/{idpasien}/{idreg}/{penjualan_id}', 'CopyResepController@form_penjualan_bebas_baru');
Route::post('copy-resep/savedetailbebas', 'CopyResepController@save_detail_bebas_baru');
Route::get('copy-resep/deleteDetailbebas/{id}/{idpasien?}/{idreg?}/{penjualan_id?}', 'CopyResepController@deleteDetailBebasBaru');
Route::post('copy-resep/savetotalbebas', 'CopyResepController@save_totalpenjualan_bebas_baru');
Route::get('copy-resep/edit-penjualan-bebas-baru/{idreg}/{penjualan_id}', 'CopyResepController@editPenjualanBebasBaru');

//cetak kronis
Route::get('copy-resep/cetak-copy-resep-fakturkronis/{penjualan_id}', 'CopyResepController@cetakDetailKronisCopyResep');
Route::get('copy-resep/cetak-detail-resep/{penjualan_id}', 'CopyResepController@cetakDetailResep');
Route::get('copy-resep/cetak-detail-resep-farmasi/{penjualan_id}', 'CopyResepController@cetakDetailResepFarmasi');
Route::get('copy-resep/cetak-detail-resep-farmasi-tanpa-apotik/{penjualan_id}', 'CopyResepController@cetakDetailResepFarmasiTanpaApotik');
Route::get('copy-resep/cetak-resep-dokter/{penjualan_id}', 'CopyResepController@cetakResepDokter');
Route::get('copy-resep/cetak-detail-copy-resep/{penjualan_id}', 'CopyResepController@cetakDetailCopyResep');
Route::get('copy-resep/cetak-detail-copy-resep-farmasi/{penjualan_id}', 'CopyResepController@cetakDetailCopyResepFarmasi');
Route::get('copy-resep/laporan/etiket/{penjualan_id}', 'CopyResepController@cetak_etiket');
Route::get('copy-resep/cetak-detail-bebas/{penjualan_id}', 'CopyResepController@cetakDetailBebas');

// Cetak
Route::get('copy-resep/cetak-obat-rujukan/{id}', 'CopyResepController@cetakSuratRujukan');
Route::delete('/copy-resep/hapus-obat-rujukan/{id}', 'CopyResepController@hapusObatRujukan');