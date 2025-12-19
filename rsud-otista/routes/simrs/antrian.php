<?php

Route::get('/antrian-new/antrian', 'AntrianNewController@layarlcd');
Route::get('/antrian-new/antrianbawah', 'AntrianNewController@layarlcdbawah');//new display


Route::get('/antrian-new/antrianumum', 'AntrianNewController@layarlcdumum');//new display


Route::get('/antrian-new/antrian-atas', 'AntrianNewController@layarlcdAtas');
Route::get('/antrian-new/antrianatas', 'AntrianNewController@layarlcdAtasNew');//new display

Route::get('/antrian-new/suara', 'AntrianNewController@suaraAntrian')->name('antrian_new.ajax_suara');
Route::get('/antrian-new/suara-umum', 'AntrianNewController@suaraAntrianUmum')->name('antrian_new.ajax_suara_umum');
Route::get('/antrian-new/suara-atas', 'AntrianNewController@suaraAntrianAtas')->name('antrian_new.ajax_suara_atas');
Route::get('/antrian-new/cek', 'AntrianNewController@cekAntrian')->name('antrian_new.cek');
Route::get('/antrian-new/cek-umum', 'AntrianNewController@cekAntrianUmum')->name('antrian_new.cek');

Route::get('/antrian-new/terpanggil', 'AntrianNewController@baruSajaDipanggil')->name('antrian_new.terpanggil');
Route::get('/antrian-new/terpanggil-loket', 'AntrianNewController@baruSajaDipanggilLoket')->name('antrian_new.terpanggilloket');

// DISPLAY NEWS
Route::get('/antrian-new/terpanggil-new/{bagian}', 'AntrianNewController@baruSajaDipanggilNew')->name('antrian_new.terpanggil_new');
Route::get('/antrian-new/terpanggil-loket-new/{bagian}', 'AntrianNewController@baruSajaDipanggilLoketNew')->name('antrian_new.terpanggilloket_new');

// ANTRIAN NEWS
Route::get('/antrian-news/{bagian}/{no_loket}/daftarpanggil', 'AntrianNewController@daftarpanggilNew');
Route::get('/antrian-news/{bagian}/{no_loket}/daftarantrian', 'AntrianNewController@daftarantrianNew');
Route::get('/antrian-news/{bagian}/{no_loket}/panggil/{id}', 'AntrianNewController@panggilNew');
Route::get('/antrian-news/{bagian}/{no_loket}/panggilkembali/{id}', 'AntrianNewController@panggilkembaliNew');

Route::get('/antrian-news-statistik-registrasi', 'AntrianNewController@getStatistikRegistrasi');

Route::get('/antrian-news/datalayarlcd/umum', 'AntrianNewController@datalayarlcdumum')->name('antriannew.datalayarlcdumum');;
Route::get('/antrian-news/datalayarlcd/{bagian}/{no_loket}', 'AntrianNewController@datalayarlcdbawahnew')->name('antriannew.datalayarlcdjkn');;
// Route::get('/antrian-news/{no_loket}/registrasi/{id}/{jenis?}', 'AntrianNewController@registrasi');
// Route::get('/antrian-news/{no_loket}/reg_pasienlama/{id}/{jenis?}', 'AntrianNewController@reg_pasienlama');
// Route::get('/antrian-news/{no_loket}/reg_blmterdata/{id}/{jenis?}', 'AntrianNewController@reg_blm_terdata');

Route::view('/antrian/antrian', 'antrian.antrian');
Route::post('/antrian2/savetouch', 'AntrianController@savetouch');
Route::get('/antrian2/datalayarlcd', 'AntrianController@datalayarlcd')->name('antrian2.datalayarlcd');
Route::get('/antrian2/layarlcd', 'AntrianController@layarlcd')->name('antrian2.layarlcd');

Route::group(['middleware' => ['role:rekammedis|administrator']], function () {
	Route::get('/antrian2/daftarpanggil', 'AntrianController@daftarpanggil')->name('antrian2.daftarpanggil'); //Data
	Route::get('/antrian2/daftarantrian', 'AntrianController@daftarantrian')->name('antrian2.daftarantrian'); //Halaman Daftar Antrian
	Route::get('/antrian2/panggil/{id}', 'AntrianController@panggil')->name('antrian2.panggil');
	Route::get('/antrian2/panggilkembali/{id}', 'AntrianController@panggilkembali')->name('antrian2.panggilkembali');
	Route::get('/antrian2/registrasi/{id}/{jenis?}', 'AntrianController@registrasi');
	Route::get('/antrian2/reg_pasienlama/{id}/{jenis?}', 'AntrianController@reg_pasienlama');
	Route::get('/antrian2/reg_blmterdata/{id}/{jenis?}', 'AntrianController@reg_blm_terdata');
});

//ANTRIAN 3
Route::post('/antrian3/savetouch', 'Antrian3Controller@savetouch');
Route::get('/antrian3/datalayarlcd', 'Antrian3Controller@datalayarlcd')->name('antrian3.datalayarlcd');
Route::get('/antrian3/layarlcd', 'Antrian3Controller@layarlcd')->name('antrian3.layarlcd');

Route::group(['middleware' => ['role:rekammedis|administrator']], function () {
	Route::get('/antrian3/daftarpanggil', 'Antrian3Controller@daftarpanggil')->name('antrian3.daftarpanggil'); //Data
	Route::get('/antrian3/daftarantrian', 'Antrian3Controller@daftarantrian')->name('antrian3.daftarantrian'); //Halaman Daftar Antrian
	Route::get('/antrian3/panggil/{id}', 'Antrian3Controller@panggil')->name('antrian3.panggil');
	Route::get('/antrian3/panggilkembali/{id}', 'Antrian3Controller@panggilkembali')->name('antrian3.panggilkembali');
	Route::get('/antrian3/registrasi/{id}/{jenis?}', 'Antrian3Controller@registrasi');
	Route::get('/antrian3/reg_pasienlama/{id}/{jenis?}', 'Antrian3Controller@reg_pasienlama');
	Route::get('/antrian3/reg_blmterdata/{id}/{jenis?}', 'Antrian3Controller@reg_blm_terdata');
});

//ANTRIAN 4
Route::post('/antrian4/savetouch', 'Antrian4Controller@savetouch');
Route::get('/antrian4/datalayarlcd', 'Antrian4Controller@datalayarlcd')->name('antrian4.datalayarlcd');
Route::get('/antrian4/layarlcd', 'Antrian4Controller@layarlcd')->name('antrian4.layarlcd');

Route::group(['middleware' => ['role:rekammedis|administrator']], function () {
	Route::get('/antrian4/daftarpanggil', 'Antrian4Controller@daftarpanggil')->name('antrian4.daftarpanggil'); //Data
	Route::get('/antrian4/daftarantrian', 'Antrian4Controller@daftarantrian')->name('antrian4.daftarantrian'); //Halaman Daftar Antrian
	Route::get('/antrian4/panggil/{id}', 'Antrian4Controller@panggil')->name('antrian4.panggil');
	Route::get('/antrian4/panggilkembali/{id}', 'Antrian4Controller@panggilkembali')->name('antrian4.panggilkembali');
	Route::get('/antrian4/registrasi/{id}/{jenis?}', 'Antrian4Controller@registrasi');
	Route::get('/antrian4/reg_pasienlama/{id}/{jenis?}', 'Antrian4Controller@reg_pasienlama');
	Route::get('/antrian4/reg_blmterdata/{id}/{jenis?}', 'Antrian4Controller@reg_blm_terdata');
});

//ANTRIAN 5
Route::post('/antrian5/savetouch', 'Antrian5Controller@savetouch');
Route::get('/antrian5/datalayarlcd', 'Antrian5Controller@datalayarlcd')->name('antrian5.datalayarlcd');
Route::get('/antrian5/layarlcd', 'Antrian5Controller@layarlcd')->name('antrian5.layarlcd');

Route::group(['middleware' => ['role:rekammedis|administrator']], function () {
	Route::get('/antrian5/daftarpanggil', 'Antrian5Controller@daftarpanggil')->name('antrian5.daftarpanggil'); //Data
	Route::get('/antrian5/daftarantrian', 'Antrian5Controller@daftarantrian')->name('antrian5.daftarantrian'); //Halaman Daftar Antrian
	Route::get('/antrian5/panggil/{id}', 'Antrian5Controller@panggil')->name('antrian5.panggil');
	Route::get('/antrian5/panggilkembali/{id}', 'Antrian5Controller@panggilkembali')->name('antrian5.panggilkembali');
	Route::get('/antrian5/registrasi/{id}/{jenis?}', 'Antrian5Controller@registrasi');
	Route::get('/antrian5/reg_pasienlama/{id}/{jenis?}', 'Antrian5Controller@reg_pasienlama');
	Route::get('/antrian5/reg_blmterdata/{id}/{jenis?}', 'Antrian5Controller@reg_blm_terdata');
});

//ANTRIAN 6
Route::post('/antrian6/savetouch', 'Antrian6Controller@savetouch');
Route::get('/antrian6/datalayarlcd', 'Antrian6Controller@datalayarlcd')->name('antrian6.datalayarlcd');
Route::get('/antrian6/layarlcd', 'Antrian6Controller@layarlcd')->name('antrian6.layarlcd');

Route::group(['middleware' => ['role:rekammedis|administrator']], function () {
	Route::get('/antrian6/daftarpanggil', 'Antrian6Controller@daftarpanggil')->name('antrian6.daftarpanggil'); //Data
	Route::get('/antrian6/daftarantrian', 'Antrian6Controller@daftarantrian')->name('antrian6.daftarantrian'); //Halaman Daftar Antrian
	Route::get('/antrian6/panggil/{id}', 'Antrian6Controller@panggil')->name('antrian6.panggil');
	Route::get('/antrian6/panggilkembali/{id}', 'Antrian6Controller@panggilkembali')->name('antrian6.panggilkembali');
	Route::get('/antrian6/registrasi/{id}/{jenis?}', 'Antrian6Controller@registrasi');
	Route::get('/antrian6/reg_pasienlama/{id}/{jenis?}', 'Antrian6Controller@reg_pasienlama');
	Route::get('/antrian6/reg_blmterdata/{id}/{jenis?}', 'Antrian6Controller@reg_blm_terdata');
});



// // ANTRIAN POLI
// Route::post('/antrian_poli/savetouch', 'AntrianPoliController@savetouch');
// Route::get('/antrian_poli/datalayarlcd/{poli_id}', 'AntrianPoliController@datalayarlcd');
// Route::get('/antrian_poli/antrian_terakhir', 'AntrianPoliController@dataAntrianTerakhir');
// Route::post('/antrian_poli/getdisplay', 'AntrianPoliController@getDisplay');
// Route::get('/antrian_poli/layarlcd', 'AntrianPoliController@layarlcd')->name('antrian_poli.layarlcd');
// Route::get('/antrian_poli/layarlcd2', 'AntrianPoliController@layarlcd2');
// Route::get('/antrian_poli/layarlcd3', 'AntrianPoliController@layarlcd3');
// Route::get('/antrian_poli/suara', 'AntrianPoliController@suara')->name('antrian_poli.suara');


Route::group(['middleware' => ['auth']], function () {
	Route::get('/antrian_poli/daftarpanggil', 'AntrianPoliController@daftarpanggil')->name('antrian_poli.daftarpanggil'); //Data
	Route::get('/antrian_poli/daftarantrian', 'AntrianPoliController@daftarantrian')->name('antrian_poli.daftarantrian'); //Halaman Daftar Antrian
	Route::post('/antrian_poli/proses-antrian', 'AntrianPoliController@prosesAntrian');
	Route::get('/antrian_poli/panggil/{id}', 'AntrianPoliController@panggil')->name('antrian_poli.panggil');
	Route::get('/antrian_poli/panggilkembali/{id}/{poli}/{reg_id}', 'AntrianPoliController@panggilkembali');
	Route::get('/antrian_poli/panggilkembali2/{nomor}/{id}/{poli}/{reg_id}', 'AntrianPoliController@panggilkembali2');
	Route::get('/antrian_poli/registrasi/{id}/{jenis?}', 'AntrianPoliController@registrasi');
	Route::get('/antrian_poli/reg_pasienlama/{id}/{jenis?}', 'AntrianPoliController@reg_pasienlama');
	Route::get('/antrian_poli/reg_blmterdata/{id}/{jenis?}', 'AntrianPoliController@reg_blm_terdata');
});
