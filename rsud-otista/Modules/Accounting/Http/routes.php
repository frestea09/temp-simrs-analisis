<?php

Route::group(['middleware' => 'web', 'prefix' => 'accounting', 'namespace' => 'Modules\Accounting\Http\Controllers'], function () {
    // Route::get('/', 'AccountingController@index');

    // Jurnal
    Route::view('journal/', 'accounting::master.journal');
    Route::resource('journal_umum', 'JournalUmumController');
    Route::resource('journal_memorial', 'JournalMemorialController');
    Route::resource('journal_operasional', 'JournalOperasionalController');
    Route::post('journal_operasional', 'JournalOperasionalController@index');
    Route::get('journal_operasional/verifikasi/{id}', 'JournalOperasionalController@verifikasi')->name('journal_operasional.verifikasi');
    Route::get('journal_operasional/verifikasi/{id}/verif', 'JournalOperasionalController@verifikasiVerif')->name('journal_operasional.verif');
    Route::resource('journal_pengeluaran', 'JournalPengeluaranController');
    Route::post('journal_pengeluaran', 'JournalPengeluaranController@index');
    Route::get('journal_pengeluaran/verifikasi/{id}', 'JournalOperasionalController@verifikasi')->name('journal_pengeluaran.verifikasi');
    Route::get('journal_pengeluaran/verifikasi/{id}/verif', 'JournalOperasionalController@verifikasiVerif')->name('journal_pengeluaran.verif');

    // Master
    Route::group(['middleware' => 'web', 'prefix' => 'master', 'namespace' => 'Master'], function () {
        Route::view('/', 'accounting::master.index');
        Route::post('akun_coa/import', 'AkunCOAController@import')->name('akun_coa.import');
        Route::get('anggaran/getData', 'AnggaranController@getAkunData');
        Route::post('anggaran/import', 'AnggaranController@import')->name('master.anggaran.import');
        Route::resource('anggaran', 'AnggaranController', ['names' => 'master.anggaran']);
        Route::resource('akun_coa', 'AkunCOAController');
        Route::resource('kas_bank', 'KasDanBankController', ['names' => 'master.kas_bank']);
    });

    // Saldo
    Route::group(['middleware' => 'web', 'prefix' => 'saldo', 'namespace' => 'Saldo'], function () {
        Route::view('/', 'accounting::saldo.index');
        Route::resource('kas_bank', 'KasDanBankController', ['names' => 'saldo.kas_bank']);
        Route::any('kas_bank_transfer/{id}', 'KasDanBankController@transferSaldo')->name('saldo.kas_bank.transfer');
        // Route::resource('supplier', 'SupplierController');
        // Route::resource('cara_bayar', 'CaraBayarController');
    });

    // Laporan
    Route::group(['middleware' => 'web', 'prefix' => 'laporan'], function () {
        Route::view('/', 'accounting::laporan.index');
        Route::any('journal', 'LaporanController@lap_journal');
        Route::any('journal_export', 'LaporanController@lap_journal_export');
        Route::any('journal_pengeluaran', 'LaporanController@lap_journal_pengeluaran');
        Route::any('journal_pengeluaran_export', 'LaporanController@lap_journal_pengeluaran_export');
        Route::any('buku_besar', 'Laporan\BukuBesarController@index');
        Route::any('buku_besar_export', 'Laporan\BukuBesarController@export');
        Route::any('buku_besar_pembantu', 'Laporan\BukuBesarController@pembantu');
        Route::any('buku_besar_pembantu_export', 'Laporan\BukuBesarController@pembantu_export');
        Route::any('neraca', 'Laporan\NeracaController@index');
        Route::any('arus_kas', 'Laporan\ArusKasController@index');
        Route::any('laba_rugi', 'Laporan\LabaRugiController@index');
    });
});
