<?php
Route::group(['middleware' => ['web', 'auth']], function () {
	
	Route::post('masterobat/import', 'MasterobatController@import');

	Route::resource('supliyer', 'SupliyerController');
	Route::resource('satuanbeli', 'SatuanbeliController');
	Route::resource('satuanjual', 'SatuanjualController');
	Route::resource('kategoriobat', 'KategoriobatController');
	Route::resource('masterobat', 'MasterobatController');
	Route::get('masterobat/{masterobat_id}/proses-satu-sehat', 'MasterobatController@prosesSatuSehat');
	Route::get('obat/getdata', 'MasterobatController@getData')->name('obat.getdata');
	Route::resource('masterobat-batches', 'LogistikBatchController');
	Route::get('obat/{id}/hapus', 'MasterobatController@hapus');
	Route::get('masterobat/{id_batch}/editbatch', 'MasterobatController@editBatch');
	Route::post('masterobat-batch-update', 'MasterobatController@updateBatch');
	Route::post('cek-batches', 'LogistikBatchController@cek_batches');
	Route::post('masterobat-batches/import', 'LogistikBatchController@import');

	//Kategori Obat
	
	Route::get('data-master-obat/{kategoriobat}', 'MasterobatController@dataMasterObat');

	Route::get('data-obat-narkotik', 'MasterobatController@dataObatNarkotik');
	Route::get('data-obat-high-alert', 'MasterobatController@dataObatHighAlert');
	Route::get('data-obat-generik', 'MasterobatController@dataObatGenerik');
	Route::get('data-obat-non-generik', 'MasterobatController@dataObatNonGenerik');
	Route::get('data-obat-fornas', 'MasterobatController@dataObatFornas');
	Route::get('data-obat-formularium', 'MasterobatController@dataObatFormularium');
	Route::get('data-obat-non_formularium', 'MasterobatController@dataObatnon_Formularium');
	Route::get('data-obat-psikotoprik', 'MasterobatController@dataObatPsikotoprik');
	Route::get('data-obat-bebas', 'MasterobatController@dataObatBebas');
	Route::get('data-obat-e-katalog', 'MasterobatController@dataObatEKatalog');
	Route::get('data-obat-lasa', 'MasterobatController@dataObatLasa');
	Route::get('data-obat-antibiotik', 'MasterobatController@dataObatAntibiotik');

	Route::get('data-obat-pengelompokan', 'MasterobatController@dataObatPengelompokan');
	Route::get('data-master-obat-pengelompokan', 'MasterobatController@dataMasterObatPengelompokan');

	Route::post('save-kategori-obat', 'MasterobatController@saveKategoriObat')->name('save-kategori-obat');
	Route::post('save-kategori-obat-pengelompokan', 'MasterobatController@saveKategoriObatPengelompokan')->name('save-kategori-obat-pengelompokan');
	
	Route::get('hapus-kategori-obat/{masterobat_id}/{kategori}', 'MasterobatController@hapusKategori');
	
	
	Route::get('get-master-obat', 'MasterobatController@getMasterObat');
});
