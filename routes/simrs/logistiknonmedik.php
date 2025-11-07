<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'logistiknonmedik'], function () {
	Route::view('master', 'logistik.logistiknonmedik.master');
	Route::view('view-penerimaan', 'logistik.logistiknonmedik.proses.penerimaan');
	Route::view('view-distribusi', 'logistik.logistiknonmedik.proses.distribusi');
	Route::view('view-kondisi', 'logistik.logistiknonmedik.proses.kondisi');
	Route::view('view-laporan', 'logistik.logistiknonmedik.proses.laporan');

	Route::resource('master-gudang', 'LogistikNonMedik\MasterGudangController');
	Route::resource('satuan-barang', 'LogistikNonMedik\SatuanBarangController');
	Route::resource('supplier-nonmedik', 'LogistikNonMedik\SuplierController');
	Route::resource('master-barang', 'LogistikNonMedik\BarangController');
	Route::resource('master-kategori', 'LogistikNonMedik\KategoriController');
	Route::resource('barang-pergudang', 'LogistikNonMedik\BarangPerGudangController');
	
	Route::resource('master-golongan', 'LogistikNonMedik\GolonganController');
	Route::resource('master-bidang', 'LogistikNonMedik\BidangController');
	Route::resource('master-kelompok', 'LogistikNonMedik\KelompokController');
	Route::resource('sub-kelompok', 'LogistikNonMedik\SubKelompokController');
	Route::resource('sub-subkelompok', 'LogistikNonMedik\SubSubKelompokController');
	Route::resource('master-periode', 'LogistikNonMedik\PeriodeController');


	Route::resource('stok-awal', 'LogistikNonMedik\StokAwalController');
	Route::resource('logistiknonmedikpo', 'LogistikNonMedik\LogistikNonMedikPoController');
	Route::get('logistiknonmedikpo-cetak/{no_po}',  'LogistikNonMedik\LogistikNonMedikPoController@cetakPO')->name('nota');

	Route::resource('logistiknonmedikPenerimaan', 'LogistikNonMedik\LogistikNonMedikPenerimaanController');
	Route::post('nonmedikpenerimaan/', 'LogistikNonMedik\LogistikNonMedikPenerimaanController@getPO');
	Route::get('nonmedikpenerimaan/add-penerimaan/{po_id}', 'LogistikNonMedik\LogistikNonMedikPenerimaanController@addPenerimaan');
	Route::get('nonmedikpenerimaan/get-item-po/{id}', 'LogistikNonMedik\LogistikNonMedikPenerimaanController@getItemPo');

	Route::resource('nonmedikpermintaan', '\App\Http\Controllers\LogistikNonMedik\LogistikNonMedikPermintaanController');
	Route::get('nonmedikpermintaan-cetak/{nomor}',  'LogistikNonMedik\LogistikNonMedikPermintaanController@cetakPermintaan')->name('cetak-permintaan');

	Route::resource('nonmediktransfer', '\App\Http\Controllers\LogistikNonMedik\LogistikNonMedikDistribusiController');
	Route::get('proses-nonmediktransfer/{nomor}',  'LogistikNonMedik\LogistikNonMedikDistribusiController@prosesTransfer')->name('proses-transfer');

	//cari
	Route::get('/get-golongan', 'LogistikNonMedik\GolonganController@getGologan')->name('golongan.data');
	Route::get('/get-bidang', 'LogistikNonMedik\BidangController@getBidang')->name('bidang.data');
	Route::get('/get-kelompok', 'LogistikNonMedik\KelompokController@getKelompok')->name('kelompok.data');
	Route::get('/get-sub-kelompok', 'LogistikNonMedik\SubKelompokController@getSubKelompok')->name('sub.kelompok.data');
	Route::get('/get-kategori', 'LogistikNonMedik\KategoriController@getKategori')->name('kategori.data');
	Route::get('/get-supplier', 'LogistikNonMedik\SuplierController@getSupplier')->name('supplier.data');
	Route::get('/get-gudang', 'LogistikNonMedik\MasterGudangController@getGudang')->name('gudang.data');
	Route::get('/get-sub-kelompok/{id}', 'LogistikNonMedik\SubKelompokController@getPilih');
	Route::get('/get-periode','LogistikNonMedik\PeriodeController@getPeriode')->name('periode.data');
	Route::get('/get-barang', 'LogistikNonMedik\BarangController@getBarang')->name('barang.data');
	Route::get('/get-satuan', 'LogistikNonMedik\SatuanBarangController@getSatuan')->name('satuan.data');
	Route::get('/cari-barang/{masterbarang_id}', 'LogistikNonMedik\LogistikNonMedikPoController@getBarang');

	//data
	Route::get('/data-po', 'LogistikNonMedik\LogistikNonMedikPoController@data')->name('data-po');
	Route::get('/data-permintaan', 'LogistikNonMedik\LogistikNonMedikPermintaanController@data')->name('data-permintaan');
	Route::get('/reset', 'LogistikNonMedik\LogistikNonMedikPoController@reset');
	Route::get('/reset-permintaan', 'LogistikNonMedik\LogistikNonMedikPermintaanController@reset');

	//laporan
	Route::get('laporan-po', 'LogistikNonMedik\LogistikNonMedikPoController@lap_po');
	Route::post('laporan-po', 'LogistikNonMedik\LogistikNonMedikPoController@lap_po_bytanggal');

	Route::get('laporan-penerimaan', 'LogistikNonMedik\LogistikNonMedikPenerimaanController@lap_penerimaan');
	Route::post('laporan-penerimaan', 'LogistikNonMedik\LogistikNonMedikPenerimaanController@lap_penerimaan_bytanggal');
});

?>