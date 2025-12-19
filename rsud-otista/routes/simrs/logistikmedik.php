<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'logistikmedik'], function () {
	Route::view('admin', 'logistik.logistikmedik.admin');
	Route::view('setup', 'logistik.logistikmedik.setup');
	Route::view('menupenerimaan', 'logistik.logistikmedik.penerimaan');
	Route::view('verifikator', 'logistik.logistikmedik.verifikator');
	Route::view('stock', 'logistik.logistikmedik.stock');
	Route::view('distribusi', 'logistik.logistikmedik.distribusi');
	Route::view('opname', 'logistik.logistikmedik.opname');
	Route::view('laporan-gudang', 'logistik.logistikmedik.laporangudang');
	Route::view('depo', 'logistik.logistikmedik.depo');
	Route::view('retur', 'logistik.logistikmedik.retur');
	Route::view('view-pejabat', 'logistik.logistikmedik.view_penjabat');
	Route::view('opname', 'logistik.logistikmedik.opname.index');

	//Kategori Obat
	Route::view('obat-narkotik', 'logistik.logistikmedik.kategoriobat.narkotik');
	Route::view('obat-high-alert', 'logistik.logistikmedik.kategoriobat.high_alert');
	Route::view('obat-generik', 'logistik.logistikmedik.kategoriobat.generik');
	Route::view('obat-non-generik', 'logistik.logistikmedik.kategoriobat.non-generik');
	Route::view('obat-fornas', 'logistik.logistikmedik.kategoriobat.fornas');
	Route::view('obat-formularium', 'logistik.logistikmedik.kategoriobat.formularium');
	Route::view('obat-e-katalog', 'logistik.logistikmedik.kategoriobat.e_katalog');
	Route::view('obat-lasa', 'logistik.logistikmedik.kategoriobat.lasa');
	Route::view('obat-antibiotik', 'logistik.logistikmedik.kategoriobat.antibiotik');
	Route::view('obat-non-formularium', 'logistik.logistikmedik.kategoriobat.non_formularium');
	Route::view('obat-psikotoprik', 'logistik.logistikmedik.kategoriobat.psikotoprik');
	Route::view('obat-bebas', 'logistik.logistikmedik.kategoriobat.bebas');
	
	Route::view('pengelompokan-obat', 'logistik.logistikmedik.kategoriobat.pengelompokan');

	// Pejabat Pengadaan
	Route::post('pejabatCreate', 'Logistik\PejabatController@pejabatCreate');
	Route::get('getPejabat/{id}', 'Logistik\PejabatController@getPejabat');
	Route::post('pejabatUpdate', 'Logistik\PejabatController@pejabatUpdate');
	Route::get('pejabat', 'Logistik\PejabatController@index')->name('pejabat');
	// Route::post('pejabatCreate', 'Logistik\PejabatController@pejabatCreate')->name('logistikmedik.pejabatCreate');

	// Pejabat Pengecekan
	Route::post('pejabatpengecekanCreate', 'Logistik\PejabatPengecekanController@pejabatpengecekanCreate');
	Route::get('getPejabatpengecekan/{id}', 'Logistik\PejabatPengecekanController@getPejabatpengecekan');
	Route::post('pejabatpengecekanUpdate', 'Logistik\PejabatPengecekanController@pejabatpengecekanUpdate');
	Route::get('pejabat-pengecekan', 'Logistik\PejabatPengecekanController@index')->name('pejabat-pengecekan');

	// Pejabat Bendahara
	Route::post('pejabatbendaharaCreate', 'Logistik\LogistikPejabatBendaharaController@pejabatbendaharaCreate');
	Route::get('getPejabatbendahara/{id}', 'Logistik\LogistikPejabatBendaharaController@getPejabatbendahara');
	Route::post('pejabatbendaharaUpdate', 'Logistik\LogistikPejabatBendaharaController@pejabatbendaharaUpdate');
	Route::get('pejabat-bendahara', 'Logistik\LogistikPejabatBendaharaController@index')->name('pejabat-bendahara');

	//Gudang
	Route::resource('gudang', 'Logistik\GudangController');
	Route::get('gudang-data', 'Logistik\GudangController@data');
	Route::get('gudang-getSatker', 'Logistik\GudangController@getSatker');
	//Supplier
	Route::resource('supplier', 'Logistik\SupplierController');
	Route::get('supplier-data', 'Logistik\SupplierController@data');
	Route::get('get-supplier', 'Logistik\SupplierController@getSupplier');
	//Periode
	Route::resource('periode', 'Logistik\PeriodeController');
	Route::get('periode-data', 'Logistik\PeriodeController@data');
	//Pengirim Penerima
	Route::resource('pengirimpenerima', 'Logistik\PengirimPenerimaController');
	Route::get('pengirimpenerima-data', 'Logistik\PengirimPenerimaController@data');

	//Proses PO
	Route::resource('po', 'Logistik\PoController');
	Route::post('cari-po', 'Logistik\PoController@po_byTanggal');
	Route::post('cari-no-po', 'Logistik\PoController@no_po_byTanggal');
	Route::get('po-data', 'Logistik\PoController@data');
	Route::get('po-data-edit', 'Logistik\PoController@dataEdit');
	Route::post('verifpphp', 'Logistik\PoController@verif_pphp');
	Route::post('cencel-po', 'Logistik\PoController@cencelpo');
	Route::post('statuspo', 'Logistik\PoController@verifstatuspo');
	Route::get('periksa/{id}', 'Logistik\PoController@cek_po');
	Route::get('list-po/{id}', 'Logistik\PoController@listPo');
	Route::post('edit-po', 'Logistik\PoController@ubahjumlah');
	Route::post('edit-ppn', 'Logistik\PoController@ubahPpn');

	Route::post('verifikator-po-verif', 'Logistik\PoController@verifPO');
	Route::post('verifikator-po-cancel', 'Logistik\PoController@cancelPO');



	// VERIFIKASI PO
	Route::get('verifikasi', 'Logistik\PoController@verifikasi');
	Route::post('verifikasi-cari-po', 'Logistik\PoController@verifikasiPObyTanggal');
	Route::post('verifikasi-cari-no-po', 'Logistik\PoController@verifikasiPObyNomor');

	// Route::get('po-cetak/{no_po}/{tanggal}', 'Logistik\PoController@cetakPO');
	Route::get('po-cetak/{no_po}/{tanggal}', 'Logistik\PoController@cetakPO_new');
	Route::get('po-edit/{supplier}/{tanggal}', 'Logistik\PoController@editPO');
	Route::get('po-hapus/{no_po}/{tanggal}', 'Logistik\PoController@hapusPO');


	//simpan Spk
	Route::post('spk', 'Logistik\LogistikSpkController@store');
	Route::post('spk-edit', 'Logistik\LogistikSpkController@saveEdit');
	Route::get('edit-spk-jumlah/{no_faktur}/{masterobat_id}', 'Logistik\LogistikSpkController@editSpk');
	Route::post('save-edit-jumlah', 'Logistik\LogistikSpkController@saveEditSpk');
	// Route::view('spk-cetak', 'logistik.logistikmedik.po.cetak_spk');

	Route::post('bapb', 'Logistik\Logistik_BAPBController@store');
	Route::get('bapb-hapus/{id}', 'Logistik\Logistik_BAPBController@destroy');
	// Route::post('spk-edit', 'Logistik\Logistik_BAPBController@saveEdit');

	//Penerimaan
	Route::post('penerimaan/import', 'Logistik\PenerimaanController@import');
	Route::resource('penerimaan', 'Logistik\PenerimaanController');
	Route::post('penerimaan/', 'Logistik\PenerimaanController@getPO');
	Route::get('penerimaan/detail-po/{no_po}', 'Logistik\PenerimaanController@detailPO');
	Route::get('penerimaan/add-penerimaan/{po_id}', 'Logistik\PenerimaanController@addPenerimaan');
	Route::get('penerimaan/get-item-po/{id}/{no_faktur}/{po_id}', 'Logistik\PenerimaanController@getItem');
	// Route::get('penerimaan/get-item-po/{id}', 'Logistik\PenerimaanController@getItemPo');
	Route::get('penerimaan/edit-get-item-po/{no_po}', 'Logistik\PenerimaanController@getEditItemPenerimaan');
	Route::post('penerimaan/savePenerimaan', 'Logistik\PenerimaanController@savePenerimaan');
	Route::post('penerimaan/editPenerimaan', 'Logistik\PenerimaanController@editPenerimaan');
	Route::post('penerimaan/editBatch/{id}', 'Logistik\PenerimaanController@editBatch');
	Route::post('penerimaan/hapusBatch/{id}', 'Logistik\PenerimaanController@hapusBatch');
	Route::get('penerimaan/list-berita-acara/{id}', 'Logistik\PenerimaanController@listPenerimaan');
	Route::get('penerimaan/list-batches/{id}', 'Logistik\PenerimaanController@listBatches');

	//Saldo Awal
	Route::get('saldoawal', 'Logistik\SaldoAwalController@index');
	Route::get('saldoawal/getGudang', 'Logistik\SaldoAwalController@getGudang');
	Route::get('saldoawal/getObat', 'Logistik\SaldoAwalController@getObat');
	Route::get('saldoawal/getSupplier', 'Logistik\SaldoAwalController@getSupplier');
	Route::get('saldoawal/getPeriode', 'Logistik\SaldoAwalController@getPeriode');
	Route::post('saldoawal', 'Logistik\SaldoAwalController@store');
	Route::get('saldoawal/data', 'Logistik\SaldoAwalController@data');

	//Kartu Stok
	Route::get('kartustok', 'Logistik\KartuStokController@index');
	Route::post('kartustok', 'Logistik\KartuStokController@dataStok');
	Route::get('kartustok/batch', 'Logistik\KartuStokController@kartuStokBatch');
	Route::post('kartustok/batch', 'Logistik\KartuStokController@kartuStokBatchFilter');
	Route::get('kartustok/gelobal', 'Logistik\KartuStokController@gelobalKartuStok');
	Route::post('kartustok/gelobalStok', 'Logistik\KartuStokController@datagelobalKartuStok');

	//Pemakaian
	Route::get('pemakaian', 'Logistik\PemakaianController@index');
	Route::post('pemakaian', 'Logistik\PemakaianController@store');
	Route::get('pemakaian-data', 'Logistik\PemakaianController@data');
	Route::post('edit-pemakaian', 'Logistik\PemakaianController@ubahjumlah');
	Route::post('pemakaian/excel', 'Logistik\PemakaianController@excel');

	//Permintaan
	Route::resource('permintaan', 'Logistik\LogistikPermintaanController');
	Route::post('permintaan-filter', 'Logistik\LogistikPermintaanController@permintaanfilter');
	Route::get('permintaan/cekStokGudangAsal/{masterobat_id}/{gudang_asal_id?}', 'Logistik\LogistikPermintaanController@cekStokGudangAsal');
	Route::get('permintaan/cekStokGudangTujuan/{masterobat_id}/{gudang_tujuan_id}', 'Logistik\LogistikPermintaanController@cekStokGudangTujuan');
	Route::get('permintaan/cekSatuanBarang/{masterobat_id}', 'Logistik\LogistikPermintaanController@cekSatuanBarang');
	Route::get('data-permintaan/', 'Logistik\LogistikPermintaanController@dataPermintaan');
	Route::get('cetak-permintaan/{nomor}', 'Logistik\LogistikPermintaanController@cetakPermintaan');
	Route::get('hapus-permintaan/{id}', 'Logistik\LogistikPermintaanController@hapusPermintaan');
	Route::post('edit-penerimaan', 'Logistik\LogistikPermintaanController@ubahqty');
	Route::get('permintaan-edit/{nomor}', 'Logistik\LogistikPermintaanController@edit_permintaan');
	Route::get('permintaan-hapus/{nomor}', 'Logistik\LogistikPermintaanController@hapus_permintaan');
	Route::post('prosesCheck/{id}', 'Logistik\LogistikPermintaanController@prosesCheck');

	//Distribusi
	Route::get('transfer-permintaan/', 'Logistik\DistribusiController@transferPermintaan');
	Route::post('transfer-permintaan/', 'Logistik\DistribusiController@transferPermintaanBytanggal');
	Route::get('transfer-permintaan-edit/{nomor}', 'Logistik\DistribusiController@transferPermintaanEdit');
	Route::get('data-permintaan-edit/', 'Logistik\DistribusiController@dataPermintaanEdit');
	Route::get('proses-transfer-permintaan/{nomor}', 'Logistik\DistribusiController@prosesTransfer');
	Route::post('hapus-transfer-permintaan/{id}', 'Logistik\DistribusiController@hapusTransfer');
	Route::put('save-proses-transfer-permintaan/{id}', 'Logistik\DistribusiController@saveProsesTransfer');
	Route::get('cetak-transfer/{nomor}', 'Logistik\DistribusiController@cetakTransferStok');
	Route::get('transfer-permintaan-depo/{id}', 'Logistik\DistribusiController@viewTransfer');
	Route::get('transfer-permintaan-depo-baru/{id}', 'Logistik\DistribusiController@viewTransferBaru');

	Route::get('edit-saldo-awal/{id}', 'Logistik\SaldoAwalController@edit');
	Route::get('hapus-saldo-awal/{id}', 'Logistik\SaldoAwalController@hapusSaldo');
	Route::post('save-edit-saldo-awal', 'Logistik\SaldoAwalController@update');
	Route::post('close-transaksi', 'Logistik\PoController@tutupTransaksi');

	// Opname
	Route::get('stok-opname', 'Logistik\OpnameController@stokOpname');
	Route::get('stok-opname/{id}', 'Logistik\OpnameController@stokOpname');
	Route::delete('stok-opname/{id}', 'Logistik\OpnameController@deleteOpname');
	Route::post('addOpname', 'Logistik\OpnameController@addOpname');
	Route::get('getObat/{id}', 'Logistik\OpnameController@getObat');
	Route::get('laporan-opname', 'Logistik\OpnameController@laporanOpname');
	Route::post('laporan-opname', 'Logistik\OpnameController@laporanOpname');
	Route::get('persediaan-stok', 'Logistik\OpnameController@lappersediaanstok');
	Route::post('persediaan-stok', 'Logistik\OpnameController@lappersediaanstok');
	Route::get('getOpname/{periode}/{gudang}', 'Logistik\OpnameController@getOpname');
	Route::post('export', 'Logistik\OpnameController@export');
	Route::get('getOpname/{id}', 'Logistik\OpnameController@getOpname');
	Route::get('getOpnameEdit/{id}', 'Logistik\OpnameController@getOpnameEdit');
	Route::post('saveOpnameEdit', 'Logistik\OpnameController@saveOpnameEdit');
	Route::get('/hapus-opname/{id}', 'Logistik\OpnameController@destroy');
	Route::get('namaObatBatch/{obat_id}/{id}', 'Logistik\OpnameController@namaObatBatch');
	Route::get('addNamaObatBatch/{obat_id}', 'Logistik\OpnameController@addNamaObatBatch');
	Route::get('editObatBatch/{id}', 'Logistik\OpnameController@editBatch');
	Route::post('saveBatch', 'Logistik\OpnameController@saveBatch');
	Route::post('editBatch', 'Logistik\OpnameController@simpanEditBatch');

	// Route::post('saveOpname', 'Logistik\OpnameController@store');
	Route::post('saveOpname/{id}', 'Logistik\OpnameController@saveOpname')->name('simpan-opname-batch');



	//get atau cari
	Route::get('data-gudang', 'Logistik\PoController@get_gudang');

	//laporan
	Route::get('laporan/po', 'Logistik\PoController@lap_po');
	Route::post('laporan/po', 'Logistik\PoController@lap_po_byTanggal');
	Route::get('laporan/pendapatan-pasien-perdepo', 'Logistik\PoController@lap_pendapatan');
	Route::post('laporan/pendapatan-pasien-perdepo', 'Logistik\PoController@lap_pendapatan_byTanggal');
	Route::get('laporan/pendapatan-pasien-bpjs', 'Logistik\PoController@lap_pendapatan_bpjs');
	Route::post('laporan/pendapatan-pasien-bpjs', 'Logistik\PoController@lap_pendapatan_bpjs_byTanggal');
	Route::get('laporan/pendapatan-pasien-bebas', 'Logistik\PoController@lap_pendapatan_bebas');
	Route::post('laporan/pendapatan-pasien-bebas', 'Logistik\PoController@lap_pendapatan_bebas_byTanggal');

	Route::get('notaPemakaian/{id}',  'Logistik\PemakaianController@cetakPemakaian')->name('nota-pemakaian');


	//cetak
	Route::get('penerimaan/cetak-penerimaan/{nomor}', 'Logistik\PenerimaanController@cetakPenerimaan');
	Route::get('penerimaan/cetak-spk/{nomor}', 'Logistik\PenerimaanController@cetakSpk');
	Route::get('penerimaan/cetak-pemeriksa-barang/{nomor}/{faktur}', 'Logistik\PenerimaanController@cetakPemeriksaBarang');

	//getmasterobat
	Route::get('master-obat', 'Logistik\PemakaianController@getMasterObat');

	// edit logistik batch ID
	Route::get('/kartustok/edit-logistik-batch-id', 'Logistik\KartuStokController@editLogistikID');
	Route::post('/kartustok/update-logistik-batch-id/{id}', 'Logistik\KartuStokController@updateLogistikID')->name('update-logistik-batch-id-stok');

	// laporan pembelian obat
	Route::get('laporan/pembelian-obat', 'Logistik\LaporanController@lap_pembelian_obat');
	Route::post('laporan/pembelian-obat', 'Logistik\LaporanController@lap_pembelian_obat_byTanggal');

	// laporan logistik medik
	Route::get('/laporan/penerimaan', 'Logistik\LaporanController@penerimaan');
	Route::post('/laporan/penerimaan', 'Logistik\LaporanController@filterPenerimaan');


	Route::get('/laporan/cetakBeritaAcara/{id}', 'Logistik\LaporanController@cetakBeritaAcara');


	// Tagihan Supplier
	Route::get('/laporan/tagihan', 'Logistik\LaporanController@tagihan');
	Route::post('/laporan/tagihan', 'Logistik\LaporanController@filterTagihan');

	// Pengeluaran
	Route::get('/laporan/pengeluaran', 'Logistik\LaporanController@pengeluaran');
	Route::post('/laporan/pengeluaran', 'Logistik\LaporanController@filterPengeluaran');
});

