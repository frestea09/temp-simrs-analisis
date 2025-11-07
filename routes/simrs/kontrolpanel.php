<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::view('/kontrolpanel/konfigurasi','kontrolpanel.konfigurasi');
  Route::view('/kontrolpanel/pengguna','kontrolpanel.pengguna');
  Route::view('/kontrolpanel/keuangan','kontrolpanel.keuangan');
  Route::view('/kontrolpanel/medis','kontrolpanel.medis');
  Route::view('/kontrolpanel/rekap-laporan','kontrolpanel.rekap-laporan');
  Route::view('/kontrolpanel/import','kontrolpanel.import');
});
